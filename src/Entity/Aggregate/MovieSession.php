<?php

namespace App\Entity\Aggregate;

use App\Entity\Client;
use App\Entity\Movie;
use App\Repository\Aggregate\MovieSessionRepository;
use Doctrine\ORM\Mapping as ORM;
use DateTimeInterface;
use http\Exception\InvalidArgumentException;

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

    /**
     * @ORM\ManyToOne(targetEntity=Client::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private array $tickets;

    public function __construct(string $id, Movie $movie, DateTimeInterface $startTime, int $quantityTickets)
    {
        $this->id = $id;
        $this->movie = $movie;
        $this->startTime = $startTime;
        $this->quantityTickets = $quantityTickets;
        $this->tickets = [];
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMovie(): ?Movie
    {
        return $this->movie;
    }

    public function setMovie(?Movie $movie): self
    {
        $this->movie = $movie;

        return $this;
    }

    public function getStartTime(): ?\DateTimeInterface
    {
        return $this->startTime;
    }

    public function setStartTime(\DateTimeInterface $startTime): self
    {
        $this->startTime = $startTime;

        return $this;
    }

    public function getQuantityTickets(): ?int
    {
        return $this->quantityTickets;
    }

    public function setQuantityTickets(int $quantityTickets): self
    {
        $this->quantityTickets = $quantityTickets;

        return $this;
    }

    /**
     * @param Client $client
     * @throws \InvalidArgumentException
     */
    public function addTickets(Client $client): void
    {
        if (!$this->isFreeTicket()) {
            throw new InvalidArgumentException("Отсутсвуют свободные билеты");
        }

        $this->tickets[] = $client;
    }

    public function isFreeTicket(): bool
    {
        return $this->getQuantityFreeTickets() > 0;
    }

    public function getQuantityFreeTickets(): int
    {
        return $this->quantityTickets - count($this->tickets);
    }

    public function getEndTime(): DateTimeInterface
    {
        $durationInMinutes = new DateInterval('PT' . $this->movie->getDurationInMinutes() . 'M');

        return $this->startTime->add($durationInMinutes);
    }
}
