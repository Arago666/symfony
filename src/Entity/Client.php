<?php

namespace App\Entity;

use App\Entity\Aggregate\MovieSession;
use App\Entity\ValueObject\NameClient;
use App\Repository\ClientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ClientRepository::class)
 */
class Client
{
    /**
     * @ORM\Id
     * @ORM\Column(type = "string", length = 100)
     */
    private string $id;

    /**
     * @ORM\ManyToOne(targetEntity=NameClient::class)
     */
    private NameClient $name;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private string $phone;

    public function __construct(string $id, NameClient $name, string $phone)
    {
        $this->id = $id;
        $this->name = $name;
        $this->phone = $phone;
        $this->movieSessions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?NameClient
    {
        return $this->name;
    }

    public function setName(?NameClient $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }
}
