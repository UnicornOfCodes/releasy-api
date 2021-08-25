<?php

namespace App\Repository;

use App\Entity\Git;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Git|null find($id, $lockMode = null, $lockVersion = null)
 * @method Git|null findOneBy(array $criteria, array $orderBy = null)
 * @method Git[]    findAll()
 * @method Git[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Git::class);
    }

    // /**
    //  * @return Git[] Returns an array of Git objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Git
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
