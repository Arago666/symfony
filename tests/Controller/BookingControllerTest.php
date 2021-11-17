<?php

namespace App\Tests\Controller;

use App\Entity\Aggregate\MovieSession;
use App\Entity\Movie;
use App\Entity\TransferObject\MovieDto;
use App\Repository\Aggregate\MovieSessionRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Uid\Uuid;
use DateTime;

class BookingControllerTest extends WebTestCase
{
    public $client;
    public $movieSessionRepository;

    public function setUp(): void
    {
        $this->client = static::createClient();
        $this->movieSessionRepository = static::$container->get(MovieSessionRepository::class);
    }

    public function testAddTicket(): void
    {
        $movieSession = $this->movieSessionRepository->findAll()[0];
        $movieSessionId = $movieSession->getId();

        $this->client->request('GET', '/booking_create', [
            'movieSessionId' => $movieSessionId,
            'name' => 'Artem Manaenkov',
            'phone' => '8-950-594-1188'
        ]);

        $this->assertTrue(true);
    }

    public function testAddTicketWithOutName(): void
    {
        $movieSession = $this->movieSessionRepository->findAll()[0];
        $movieSessionId = $movieSession->getId();

        $this->client->request('GET', '/booking_create', [
            'movieSessionId' => $movieSessionId,
            'phone' => '8-950-594-1188'
        ]);

        $this->assertTrue(true);
    }

    public function testAddTicketWithOutPhone(): void
    {
        $movieSession = $this->movieSessionRepository->findAll()[0];
        $movieSessionId = $movieSession->getId();

        $this->client->request('GET', '/booking_create', [
            'movieSessionId' => $movieSessionId,
            'name' => 'Artem Manaenkov'
        ]);

        $this->assertTrue(true);
    }

    public function testAddTicketWithInvalidId(): void
    {
        $movieSessionId = 'Invalid id';

        $this->client->request('GET', '/booking_create', [
            'movieSessionId' => $movieSessionId,
            'name' => 'Artem Manaenkov',
            'phone' => '8-950-594-1188'
        ]);

        $this->assertTrue(true);
    }

    public function testQuantityTicketAfterAddTicket(): void
    {
        $movieSession = $this->movieSessionRepository->findAll()[0];
        $movieSessionId = $movieSession->getId();

        $quantityTicketAfterAddTicket = $movieSession->getQuantityTickets() - 1;

        $this->client->request('GET', '/booking_create', [
            'movieSessionId' => $movieSessionId,
            'name' => 'Artem Manaenkov',
            'phone' => '8-950-594-1188'
        ]);

        $this->assertSame($quantityTicketAfterAddTicket, $movieSession->getQuantityTickets());
    }

    public function testAddTicketWithOutFreeTicket(): void
    {
        $movieSession = $this->addMovieSessionWithOutTickets();
        $movieSessionId = $movieSession->getId();

        $this->client->request('GET', '/booking_create', [
            'movieSessionId' => $movieSessionId,
            'name' => 'Artem Manaenkov',
            'phone' => '8-950-594-1188'
        ]);

        $this->assertTrue(true);
    }

    private function addMovieSessionWithOutTickets()
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

        $kernel = self::bootKernel();
        $entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();

        $entityManager->persist($movie);
        $entityManager->persist($movieSession);
        $entityManager->flush();

        return $movieSession;
    }
}
