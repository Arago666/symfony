<?php

namespace App\Repository\Aggregate;

use App\Entity\Aggregate\MovieSession;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MovieSession|null find($id, $lockMode = null, $lockVersion = null)
 * @method MovieSession|null findOneBy(array $criteria, array $orderBy = null)
 * @method MovieSession[]    findAll()
 * @method MovieSession[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MovieSessionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MovieSession::class);
    }

    public function save(MovieSession $movieSession): void
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($movieSession);
        $entityManager->flush();
    }
}
