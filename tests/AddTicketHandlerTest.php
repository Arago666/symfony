<?php

namespace App\Tests;

use App\Entity\Aggregate\MovieSession;
use App\Entity\Movie;
use App\Entity\TransferObject\MovieDto;
use App\Message\AddTicketCommand;
use App\MessageHandler\AddTicketHandler;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Uid\Uuid;
use DateTime;

class AddTicketHandlerTest extends WebTestCase
{
    public function testAddTicketCommand(): void
    {
        $client = static::createClient();

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

        $id = Uuid::v4();
        $fistName = 'Artem';
        $phone = '8-950-594-1188';

        $command = new AddTicketCommand(
            $id,
            $fistName,
            $phone,
            $movieSession
        );

        $this->assertEquals($id, $command->getId());
        $this->assertEquals($fistName, $command->getFirstName());
        $this->assertEquals($phone, $command->getPhone());
        $this->assertEquals($movieSession, $command->getMovieSession());
    }


    public function testAddTicketHandler(): void
    {
        $client = static::createClient();

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

        $id = Uuid::v4();
        $fistName = 'Artem';
        $phone = '8-950-594-1188';

        $command = new AddTicketCommand(
            $id,
            $fistName,
            $phone,
            $movieSession
        );

        $kernel = self::bootKernel();
        $entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();

        $entityManager->persist($movie);
        $entityManager->persist($movieSession);
        $entityManager->flush();

        $movieSessionRepository = static::$container->get(AddTicketHandler::class);
        $movieSessionRepository($command);

        $this->assertTrue(true);
    }
}
