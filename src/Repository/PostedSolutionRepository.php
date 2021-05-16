<?php

namespace App\Repository;

use App\Entity\PostedSolution;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PostedSolution|null find($id, $lockMode = null, $lockVersion = null)
 * @method PostedSolution|null findOneBy(array $criteria, array $orderBy = null)
 * @method PostedSolution[]    findAll()
 * @method PostedSolution[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostedSolutionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PostedSolution::class);
    }

    public function getSolutionsToReview($user)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.user = :user')
            ->setParameter('user', $user)
            ->getQuery()
            ->getResult();
    }
    // /**
    //  * @return PostedSolution[] Returns an array of PostedSolution objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PostedSolution
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
