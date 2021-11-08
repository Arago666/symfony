<?php

namespace App\Command;

use App\Entity\Aggregate\MovieSession;

class AddTicketCommand
{
    public string $id;
    public string $firstName;
    public string $phone;
    public MovieSession $movieSession;
}