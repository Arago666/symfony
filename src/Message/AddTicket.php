<?php

namespace App\Message;

use App\Entity\Client;

class AddTicket
{
    private string $movieId;
    private Client $client;

    public function __construct(string $movieId, Client $client)
    {
        $this->movieId = $movieId;
        $this->client = $client;
    }

    public function getMovieId(): string
    {
        return $this->movieId;
    }

    public function getClient(): Client
    {
        return $this->client;
    }

}