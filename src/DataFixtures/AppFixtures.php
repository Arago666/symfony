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
        $movieFirst = $this->loadMovie('The Dark Knight', 152);
        $manager->persist($movieFirst);

        $movieSecond = $this->loadMovie('Iron Man', 121);
        $manager->persist($movieSecond);

        $movieSessionFirst = new MovieSession(
            Uuid::v4(),
            $movieFirst,
            new DateTime('2021-11-25T16:55:00'),
            100
        );
        $manager->persist($movieSessionFirst);

        $movieSessionSecond = new MovieSession(
            Uuid::v4(),
            $movieFirst,
            new DateTime('2021-12-01T10:30:00'),
            300
        );
        $manager->persist($movieSessionSecond);

        $movieSessionThird = new MovieSession(
            Uuid::v4(),
            $movieSecond,
            new DateTime('2021-12-01T20:15:00'),
            200
        );
        $manager->persist($movieSessionThird);

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
