<?php

namespace App\MessageHandler;

use App\Message\AddTicket;
use App\Repository\Aggregate\MovieSessionRepository;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class AddTicketHandler implements MessageHandlerInterface
{
    private MovieSessionRepository $movieSessionRepository;

    public function __construct(MovieSessionRepository $movieSessionRepository)
    {
        $this->movieSessionRepository = $movieSessionRepository;
    }

    public function __invoke(AddTicket $movieTicket)
    {
        $movieSession = $this->movieSessionRepository->find($movieTicket->getMovieId());
        $movieSession->addTickets($movieTicket->getClient());
        $movieSession->reduceFreeTicket();
    }
}