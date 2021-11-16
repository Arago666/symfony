<?php

namespace App\Tests;

use App\Entity\Aggregate\MovieSession;
use App\Entity\Movie;
use App\Entity\TransferObject\MovieDto;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;
use DateTime;

class MovieSessionTest extends TestCase
{
    public function testSomething(): void
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

        $this->assertSame($id, $movieSession->getId());
        $this->assertSame($movie, $movieSession->getMovie());
        $this->assertSame($startTime, $movieSession->getStartTime());
        $this->assertSame($quantityTickets, $movieSession->getQuantityTickets());

        $this->assertSame(true, $movieSession->isFreeTicket());
        $movieSession->reduceFreeTicket();
        $this->assertSame(false, $movieSession->isFreeTicket());

        $this->assertTrue(true);
    }
}
