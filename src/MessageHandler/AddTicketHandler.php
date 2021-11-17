<?php

namespace App\MessageHandler;

use App\Entity\Ticket;
use App\Message\AddTicketCommand;
use App\Repository\TicketRepository;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class AddTicketHandler implements MessageHandlerInterface
{
    private TicketRepository $ticketRepository;

    public function __construct(TicketRepository $ticketRepository)
    {
        $this->ticketRepository = $ticketRepository;
    }

    public function __invoke(AddTicketCommand $command): void
    {
        $ticket = new Ticket(
            $command->getId(),
            $command->getFirstName(),
            $command->getPhone(),
            $command->getMovieSession()
        );

        $command->getMovieSession()->addTicket($ticket);

        $this->ticketRepository->save($ticket);
    }
}