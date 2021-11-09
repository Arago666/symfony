<?php

namespace App\Message;

use App\Entity\Aggregate\MovieSession;
use App\Entity\Ticket;

class AddTicket extends Ticket
{
    public string $id;
    public string $firstName;
    public string $phone;
    public MovieSession $movieSession;

    public function __construct(string $id, string $firstName, string $phone, MovieSession $movieSession)
    {
        $this->id = $id;
        $this->firstName = $firstName;
        $this->phone = $phone;
        $this->movieSession = $movieSession;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function getMovieSession(): MovieSession
    {
        return $this->movieSession;
    }
}