<?php

namespace App\Entity;

use App\Entity\TransferObject\MovieDto;
use App\Repository\MovieRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MovieRepository::class)
 */
class Movie
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $name;

    /**
     * @ORM\Column(type="integer")
     */
    private int $durationInMinutes;

    public function __construct(string $id, MovieDto $movieDto)
    {
        $this->id = $id;
        $this->name = $movieDto->name;
        $this->durationInMinutes = $movieDto->durationInMinutes;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDurationInMinutes(): ?int
    {
        return $this->durationInMinutes;
    }

    public function setDurationInMinutes(int $durationInMinutes): self
    {
        $this->durationInMinutes = $durationInMinutes;

        return $this;
    }
}
