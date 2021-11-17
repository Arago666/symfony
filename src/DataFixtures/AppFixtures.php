<?php

namespace App\DataFixtures;

use App\Entity\Aggregate\MovieSession;
use App\Entity\Movie;
use App\Entity\TransferObject\MovieDto;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use DateTime;
use Symfony\Component\Uid\Uuid;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $movieSessionArray = [
            [
                'movie'             =>  'The Dark Knight',
                'durationInMinutes' => 152,
                'startDate'         => '2021-11-25T16:55:00',
                'quantityTicket'    => 300

            ],
            [
                'movie'             =>  'Iron Man',
                'durationInMinutes' => 121,
                'startDate'         => '2021-11-25T10:00:00',
                'quantityTicket'    => 200
            ],

        ];

        foreach ($movieSessionArray as $movieItem) {
            $movie = $this->loadMovie(
                $movieItem['movie'],
                $movieItem['durationInMinutes']
            );

            $manager->persist($movie);

            $movieSession = new MovieSession(
                Uuid::v4(),
                $movie,
                new DateTime($movieItem['startDate']),
                $movieItem['quantityTicket']
            );

            $manager->persist($movieSession);
        }

        $manager->flush();
    }

    private function loadMovie(string $name, int $durationInMinutes)
    {
        $movieDTO = new MovieDto([
            'name' => $name,
            'durationInMinutes' => $durationInMinutes
        ]);

        return new Movie(
            Uuid::v4(),
            $movieDTO
        );
    }
}
