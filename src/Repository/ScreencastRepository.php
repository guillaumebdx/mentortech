<?php

namespace App\Repository;

use App\Entity\Screencast;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Screencast|null find($id, $lockMode = null, $lockVersion = null)
 * @method Screencast|null findOneBy(array $criteria, array $orderBy = null)
 * @method Screencast[]    findAll()
 * @method Screencast[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ScreencastRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Screencast::class);
    }

    // /**
    //  * @return Screencast[] Returns an array of Screencast objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Screencast
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
