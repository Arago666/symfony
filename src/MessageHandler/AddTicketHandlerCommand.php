<?php

namespace App\MessageHandler;

use App\Entity\Ticket;
use App\Repository\Aggregate\MovieSessionRepository;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Doctrine\Persistence\ManagerRegistry;

class AddTicketHandlerCommand implements MessageHandlerInterface
{
    private MovieSessionRepository $movieSessionRepository;
    private ManagerRegistry $doctrine;

    public function __construct(MovieSessionRepository $movieSessionRepository, ManagerRegistry $doctrine)
    {
        $this->movieSessionRepository = $movieSessionRepository;
        $this->doctrine = $doctrine;
    }

    public function __invoke(Ticket $movieTicket): void
    {
        $this->doctrine->getManager()->persist($movieTicket);
        $this->doctrine->getManager()->flush();

        $movieSession = $this->movieSessionRepository->find($movieTicket->getMovieSession());
        $movieSession->addTickets();

        $this->doctrine->getManager()->persist($movieSession);
        $this->doctrine->getManager()->flush();
    }
}