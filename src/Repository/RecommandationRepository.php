<?php

namespace App\Repository;

use App\Entity\Recommandation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Enterprise;

/**
 * @method Recommandation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Recommandation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Recommandation[]    findAll()
 * @method Recommandation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RecommandationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Recommandation::class);
    }

    public function findWhereName($value)
    {
        /*SELECT name FROM brandvisor.recommandation
        JOIN enterprise ON recommandation.enterprise_id = enterprise.id
        WHERE name LIKE '%%';*/
        return $this->createQueryBuilder('r')
            ->join('r.enterprise', 'en')
            ->where('en.name LIKE :val')
            ->setParameter('val', '%' . $value . '%')
            ->getQuery()
            ->getResult();
    }

    // /**
    //  * @return Recommandation[] Returns an array of Recommandation objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Recommandation
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
