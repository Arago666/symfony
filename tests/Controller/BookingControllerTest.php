<?php

namespace App\Tests\Controller;

use App\Repository\Aggregate\MovieSessionRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BookingControllerTest extends WebTestCase
{
    public function testSomething(): void
    {
        $client = static::createClient();

        $movieSessionRepository = static::$container->get(MovieSessionRepository::class);
        $movieSession = $movieSessionRepository->findAll()[0];
        $movieSessionId = $movieSession->getId();

        $quantityTicketAfterAddTicket = $movieSession->getQuantityTickets() - 1;

        $client->request('GET', '/booking_create', [
            'movieSessionId' => $movieSessionId,
            'name' => 'Artem Manaenkov',
            'phone' => '8-950-594-1188'
        ]);

        $this->assertSame($quantityTicketAfterAddTicket, $movieSession->getQuantityTickets());
    }
}
