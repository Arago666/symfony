<?php

namespace App\Entity\Aggregate;

use App\Entity\Movie;
use App\Entity\Ticket;
use App\Repository\Aggregate\MovieSessionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use DateTimeInterface;
use Exception;
use Symfony\Component\Uid\Uuid;

/**
 * @ORM\Entity(repositoryClass=MovieSessionRepository::class)
 */
class MovieSession
{
    /**
     * @ORM\Id
     * @ORM\Column(type = "uuid")
     */
    private Uuid $id;

    /**
     * @ORM\ManyToOne(targetEntity=Movie::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private Movie $movie;

    /**
     * @ORM\Column(type="datetime")
     */
    private DateTimeInterface $startTime;

    /**
     * @ORM\Column(type="integer")
     */
    private int $quantityTickets;

    /**
     * @ORM\OneToMany(targetEntity=Ticket::class, cascade={"persist"}, mappedBy="movieSession")
     * @ORM\JoinColumn(nullable=true)
     */
    private Collection $tickets;

    public function __construct(Uuid $id, Movie $movie, DateTimeInterface $startTime, int $quantityTickets)
    {
        $this->id = $id;
        $this->movie = $movie;
        $this->startTime = $startTime;
        $this->quantityTickets = $quantityTickets;
        $this->tickets = new ArrayCollection([]);
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getMovie(): ?Movie
    {
        return $this->movie;
    }

    public function getStartTime(): ?\DateTimeInterface
    {
        return $this->startTime;
    }

    public function getQuantityTickets(): ?int
    {
        return $this->quantityTickets;
    }

    public function addTicket(Ticket $ticket): void
    {
        if (!$this->isFreeTicket()) {
            throw new Exception("Отсутсвуют свободные билеты");
        }

        $this->reduceFreeTicket();
        $this->tickets->add($ticket);
    }

    public function isFreeTicket(): bool
    {
        return $this->getQuantityTickets() > 0;
    }

    public function reduceFreeTicket(): bool
    {
        return $this->quantityTickets = $this->quantityTickets - 1;
    }

    public function getEndTime(): DateTimeInterface
    {
        $durationInMinutes = new DateInterval('PT' . $this->movie->getDurationInMinutes() . 'M');

        return $this->startTime->add($durationInMinutes);
    }
}
