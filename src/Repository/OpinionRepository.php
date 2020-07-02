<?php

namespace App\Repository;

use App\Entity\Opinion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\User;

/**
 * @method Opinion|null find($id, $lockMode = null, $lockVersion = null)
 * @method Opinion|null findOneBy(array $criteria, array $orderBy = null)
 * @method Opinion[]    findAll()
 * @method Opinion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OpinionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Opinion::class);
    }

    public function findConsummerOpinions()
    {
        return $this->createQueryBuilder('o')
            ->join(User::class, 'u')
            ->where('u.id = o.depositary')
            ->andWhere('u.roles LIKE :role')
            ->setParameter('role', '%ROLE_CONSUMER%')
            ->orderBy('o.date', 'DESC')
            ->setMaxResults(2)
            ->getQuery()
            ->getResult();
    }

    public function findExpertOpinions()
    {
        return $this->createQueryBuilder('o')
            ->join(User::class, 'u')
            ->where('u.id = o.depositary')
            ->andWhere('u.roles LIKE :role')
            ->setParameter('role', '%ROLE_EXPERT%')
            ->orderBy('o.date', 'DESC')
            ->setMaxResults(2)
            ->getQuery()
            ->getResult();
    }
    // /**
    //  * @return Opinion[] Returns an array of Opinion objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Opinion
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
