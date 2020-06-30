<?php

namespace App\Repository;

use App\Entity\EnterpriseCategories;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method EnterpriseCategories|null find($id, $lockMode = null, $lockVersion = null)
 * @method EnterpriseCategories|null findOneBy(array $criteria, array $orderBy = null)
 * @method EnterpriseCategories[]    findAll()
 * @method EnterpriseCategories[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EnterpriseCategoriesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EnterpriseCategories::class);
    }

    // /**
    //  * @return EnterpriseCategories[] Returns an array of EnterpriseCategories objects
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
    public function findOneBySomeField($value): ?EnterpriseCategories
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
