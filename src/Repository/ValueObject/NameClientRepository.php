<?php

namespace App\Repository\ValueObject;

use App\Entity\ValueObject\NameClient;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method NameClient|null find($id, $lockMode = null, $lockVersion = null)
 * @method NameClient|null findOneBy(array $criteria, array $orderBy = null)
 * @method NameClient[]    findAll()
 * @method NameClient[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NameClientRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NameClient::class);
    }

    // /**
    //  * @return NameClient[] Returns an array of NameClient objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('n.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?NameClient
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
