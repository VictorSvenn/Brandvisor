<?php

namespace App\Repository;

use App\Entity\EnterpriseType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method EnterpriseType|null find($id, $lockMode = null, $lockVersion = null)
 * @method EnterpriseType|null findOneBy(array $criteria, array $orderBy = null)
 * @method EnterpriseType[]    findAll()
 * @method EnterpriseType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EnterpriseTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EnterpriseType::class);
    }

    // /**
    //  * @return EnterpriseType[] Returns an array of EnterpriseType objects
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
    public function findOneBySomeField($value): ?EnterpriseType
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
