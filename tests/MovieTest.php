<?php

namespace App\Tests;

use App\Entity\Movie;
use App\Entity\TransferObject\MovieDto;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;

class MovieTest extends TestCase
{
    public function testSomething(): void
    {
        $id = Uuid::v4();
        $name = 'test';
        $durationInMinutes = 120;

        $movieDTO = new MovieDto([
            'name' => $name,
            'durationInMinutes' => $durationInMinutes
        ]);

        $movie = new Movie(
            $id,
            $movieDTO
        );

        $this->assertSame($id, $movie->getId());
        $this->assertSame($name, $movie->getName());
        $this->assertSame($durationInMinutes, $movie->getDurationInMinutes());

        $this->assertTrue(true);
    }
}
