<?php

namespace App\Entity\Aggregate;

use App\Entity\Movie;
use App\Repository\Aggregate\MovieSessionRepository;
use Doctrine\ORM\Mapping as ORM;
use DateTimeInterface;
use InvalidArgumentException;

/**
 * @ORM\Entity(repositoryClass=MovieSessionRepository::class)
 */
class MovieSession
{
    /**
     * @ORM\Id
     * @ORM\Column(type = "string", length = 100)
     */
    private string $id;

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

    public function __construct(string $id, Movie $movie, DateTimeInterface $startTime, int $quantityTickets)
    {
        $this->id = $id;
        $this->movie = $movie;
        $this->startTime = $startTime;
        $this->quantityTickets = $quantityTickets;
    }

    public function getId(): ?int
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

    /**
     * @throws \InvalidArgumentException
     */
    public function addTickets(): void
    {
        if (!$this->isFreeTicket()) {
            throw new InvalidArgumentException("Отсутсвуют свободные билеты");
        }

        $this->reduceFreeTicket();
    }

    public function isFreeTicket(): bool
    {
        return $this->getQuantityFreeTickets() > 0;
    }

    public function reduceFreeTicket(): bool
    {
        return $this->quantityTickets = $this->quantityTickets - 1;
    }

    public function getQuantityFreeTickets(): ?int
    {
        return $this->quantityTickets;
    }

    public function getEndTime(): DateTimeInterface
    {
        $durationInMinutes = new DateInterval('PT' . $this->movie->getDurationInMinutes() . 'M');

        return $this->startTime->add($durationInMinutes);
    }
}
