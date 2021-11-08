<?php

namespace App\Command;

use App\Entity\Ticket;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class AddTicketCommandHandler
{
    protected ValidatorInterface $validator;
    protected RegistryInterface $doctrine;

    public function __construct(ValidatorInterface $validator, RegistryInterface $doctrine)
    {
        $this->validator = $validator;
        $this->doctrine = $doctrine;
    }

    public function handle(AddTicketCommand $command): void
    {
        $violations = $this->validator->validate($command);
        if (count($violations) != 0) {
            $error = $violations->get(0)->getMessage();
            throw new BadRequestHttpException($error);
        }

        $ticket = new Ticket($command->id, $command->firstName, $command->phone, $command->movieSession);
        $this->doctrine->getManager()->persist($ticket);
        $this->doctrine->getManager()->flush();
    }
}