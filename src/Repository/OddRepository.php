<?php

namespace App\Repository;

use App\Entity\Odd;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Odd|null find($id, $lockMode = null, $lockVersion = null)
 * @method Odd|null findOneBy(array $criteria, array $orderBy = null)
 * @method Odd[]    findAll()
 * @method Odd[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OddRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Odd::class);
    }

    // /**
    //  * @return Odd[] Returns an array of Odd objects
    //  */

    public function findWhereNameLike($value)
    {
        return $this->createQueryBuilder('o')
            ->where('o.name LIKE :val')
            ->setParameter('val', '%' . $value . '%')
            ->getQuery()
            ->getResult();
    }

    public function findAllOdd()
    {

         $results=$this->createQueryBuilder('o')
            ->select('o')
            ->getQuery()
            ->getResult();
        shuffle($results);
        return $results[0];
    }


    /*
    public function findOneBySomeField($value): ?Odd
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
