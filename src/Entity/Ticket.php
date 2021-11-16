<?php

namespace App\Entity;

use App\Entity\Aggregate\MovieSession;
use App\Repository\TicketRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

/**
 * @ORM\Entity(repositoryClass=TicketRepository::class)
 */
class Ticket
{
    /**
     * @ORM\Id
     * @ORM\Column(type="uuid")
     */
    private Uuid $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private string $firstName;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private string $phone;

    /**
     * @ORM\ManyToOne(targetEntity=MovieSession::class, inversedBy="tickets", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true, name="movie_session_id", referencedColumnName="id")
     */
    private MovieSession $movieSession;

    public function __construct(Uuid $id, string $firstName, string $phone, MovieSession $movieSession)
    {
        $this->id = $id;
        $this->firstName = $firstName;
        $this->phone = $phone;
        $this->movieSession = $movieSession;
    }

    public function getMovieSession(): MovieSession
    {
        return $this->movieSession;
    }
}
