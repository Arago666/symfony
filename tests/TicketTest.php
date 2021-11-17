<?php

namespace App\Tests;

use App\Entity\Aggregate\MovieSession;
use App\Entity\Movie;
use App\Entity\Ticket;
use App\Entity\TransferObject\MovieDto;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;
use DateTime;

class TicketTest extends TestCase
{
    public function testCreate(): void
    {
        $movieDTO = new MovieDto([
            'name' => 'TestMovie',
            'durationInMinutes' => 60
        ]);

        $movie = new Movie(
            Uuid::v4(),
            $movieDTO
        );

        $movieSession = new MovieSession(
            Uuid::v4(),
            $movie,
            new DateTime('2021-12-01T20:15:00'),
            200
        );

        $ticket = new Ticket(
            Uuid::v4(),
            'Artem',
            '8-950-594-1188',
            $movieSession
        );

        $this->assertEquals($movieSession, $ticket->getMovieSession());
    }
}
