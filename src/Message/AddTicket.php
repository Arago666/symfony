<?php

namespace App\Message;

use App\Entity\Ticket;

class AddTicket
{
    private string $movieId;
    private Ticket $ticket;

    public function __construct(string $movieId, Ticket $ticket)
    {
        $this->movieId = $movieId;
        $this->ticket = $ticket;
    }

    public function getMovieId(): string
    {
        return $this->movieId;
    }

    public function getTicket(): Ticket
    {
        return $this->ticket;
    }
}