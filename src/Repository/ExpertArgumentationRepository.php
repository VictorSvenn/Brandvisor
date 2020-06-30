<?php

namespace App\Repository;

use App\Entity\ExpertArgumentation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ExpertArgumentation|null find($id, $lockMode = null, $lockVersion = null)
 * @method ExpertArgumentation|null findOneBy(array $criteria, array $orderBy = null)
 * @method ExpertArgumentation[]    findAll()
 * @method ExpertArgumentation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExpertArgumentationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ExpertArgumentation::class);
    }

    // /**
    //  * @return ExpertArgumentation[] Returns an array of ExpertArgumentation objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ExpertArgumentation
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
