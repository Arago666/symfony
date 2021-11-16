<?php

namespace App\Entity\TransferObject;

class MovieDto
{
    public string $name;
    public int $durationInMinutes;

    /**
     * @psalm-param array{name:string, durationInMinutes:int} $data
     */
    public function __construct(array $data)
    {
        $this->name = $data['name'];
        $this->durationInMinutes = $data['durationInMinutes'];
    }
}