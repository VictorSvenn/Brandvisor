<?php

namespace App\Repository;

use App\Entity\Expert;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Expert|null find($id, $lockMode = null, $lockVersion = null)
 * @method Expert|null findOneBy(array $criteria, array $orderBy = null)
 * @method Expert[]    findAll()
 * @method Expert[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExpertRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Expert::class);
    }

    public function findWhereNameLike($value)
    {
        return $this->createQueryBuilder('e')
            ->Join(User::class, 'u')
            ->where('u.id = e.user')
            ->andWhere('u.lastName LIKE :val')
            ->setParameter('val', '%' . $value . '%')
            ->getQuery()
            ->getResult();
    }
    public function findWhereFirstNameLike($value)
    {
        return $this->createQueryBuilder('e')
            ->Join(User::class, 'u')
            ->where('u.id = e.user')
            ->andWhere('u.firstName LIKE :val')
            ->setParameter('val', '%' . $value . '%')
            ->getQuery()
            ->getResult();
    }

    // /**
    //  * @return Expert[] Returns an array of Expert objects
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
    public function findOneBySomeField($value): ?Expert
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
