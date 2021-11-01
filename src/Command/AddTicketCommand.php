<?php


namespace App\Command;

use App\Entity\ValueObject\NameClient;

class AddTicketCommand
{
    public string $id;
    public NameClient $name;
    public string $phone;
}