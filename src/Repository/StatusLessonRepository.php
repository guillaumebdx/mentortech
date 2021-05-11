<?php

namespace App\Repository;

use App\Entity\StatusLesson;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method StatusLesson|null find($id, $lockMode = null, $lockVersion = null)
 * @method StatusLesson|null findOneBy(array $criteria, array $orderBy = null)
 * @method StatusLesson[]    findAll()
 * @method StatusLesson[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StatusLessonRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StatusLesson::class);
    }

    // /**
    //  * @return StatusLesson[] Returns an array of StatusLesson objects
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
    public function findOneBySomeField($value): ?StatusLesson
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
