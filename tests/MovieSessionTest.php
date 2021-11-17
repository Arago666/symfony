<?php

namespace App\Tests;

use App\Entity\Aggregate\MovieSession;
use App\Entity\Movie;
use App\Entity\Ticket;
use App\Entity\TransferObject\MovieDto;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;
use DateTime;

class MovieSessionTest extends TestCase
{
    public function testCreate(): void
    {
        $movieDTO = new MovieDto([
            'name' => 'TestMovieSession',
            'durationInMinutes' => 20
        ]);

        $movie = new Movie(
            Uuid::v4(),
            $movieDTO
        );

        $id = Uuid::v4();
        $startTime = new DateTime('2021-12-01T20:15:00');
        $quantityTickets = 1;

        $movieSession = new MovieSession(
            $id,
            $movie,
            $startTime,
            $quantityTickets
        );

        $this->assertEquals($id, $movieSession->getId());
        $this->assertEquals($movie, $movieSession->getMovie());
        $this->assertEquals($startTime, $movieSession->getStartTime());
        $this->assertEquals($quantityTickets, $movieSession->getQuantityTickets());
    }

    public function testReduceFreeTicket(): void
    {
        $movieDTO = new MovieDto([
            'name' => 'TestMovieSession',
            'durationInMinutes' => 20
        ]);

        $movie = new Movie(
            Uuid::v4(),
            $movieDTO
        );

        $id = Uuid::v4();
        $startTime = new DateTime('2021-12-01T20:15:00');
        $quantityTickets = 1;

        $movieSession = new MovieSession(
            $id,
            $movie,
            $startTime,
            $quantityTickets
        );

        $this->assertTrue($movieSession->isFreeTicket());
        $movieSession->reduceFreeTicket();
        $this->assertFalse($movieSession->isFreeTicket());
    }

    public function testAddTicket(): void
    {
        $movieDTO = new MovieDto([
            'name' => 'TestMovieSession',
            'durationInMinutes' => 20
        ]);

        $movie = new Movie(
            Uuid::v4(),
            $movieDTO
        );

        $id = Uuid::v4();
        $startTime = new DateTime('2021-12-01T20:15:00');
        $quantityTickets = 1;

        $movieSession = new MovieSession(
            $id,
            $movie,
            $startTime,
            $quantityTickets
        );

        $ticket = new Ticket(
            Uuid::v4(),
            'Artem',
            '8-950-594-1188',
            $movieSession
        );

        $movieSession->addTicket($ticket);

        $this->assertTrue(true);
    }

    public function testAddTicketWithOutTickets(): void
    {
        $movieDTO = new MovieDto([
            'name' => 'TestMovieSession',
            'durationInMinutes' => 20
        ]);

        $movie = new Movie(
            Uuid::v4(),
            $movieDTO
        );

        $id = Uuid::v4();
        $startTime = new DateTime('2021-12-01T20:15:00');
        $quantityTickets = 0;

        $movieSession = new MovieSession(
            $id,
            $movie,
            $startTime,
            $quantityTickets
        );

        $ticket = new Ticket(
            Uuid::v4(),
            'Artem',
            '8-950-594-1188',
            $movieSession
        );

        $this->expectExceptionMessage($movieSession->addTicket($ticket));
    }

    public function testReduceQuantityTicketsInAddTicketMethod(): void
    {
        $movieDTO = new MovieDto([
            'name' => 'TestMovieSession',
            'durationInMinutes' => 20
        ]);

        $movie = new Movie(
            Uuid::v4(),
            $movieDTO
        );

        $id = Uuid::v4();
        $startTime = new DateTime('2021-12-01T20:15:00');
        $quantityTickets = 5;

        $movieSession = new MovieSession(
            $id,
            $movie,
            $startTime,
            $quantityTickets
        );

        $ticket = new Ticket(
            Uuid::v4(),
            'Artem',
            '8-950-594-1188',
            $movieSession
        );

        $movieSession->addTicket($ticket);

        $this->assertEquals((int)4, $movieSession->getQuantityTickets());
    }

}
