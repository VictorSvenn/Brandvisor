<?php

namespace App\Repository;

use App\Entity\Initiative;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Initiative|null find($id, $lockMode = null, $lockVersion = null)
 * @method Initiative|null findOneBy(array $criteria, array $orderBy = null)
 * @method Initiative[]    findAll()
 * @method Initiative[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InitiativeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Initiative::class);
    }

    // /**
    //  * @return Initiative[] Returns an array of Initiative objects
    //  */

    public function findWhereNameAndKewordsLike($value)
    {
        return $this->createQueryBuilder('i')
            ->where('i.name LIKE :val1')
            ->setParameter('val1', '%' . $value . '%')
            ->andWhere('i.keywords Like :val2')
            ->setParameter('val2', '%' . $value . '%')
            ->getQuery()
            ->getResult();
    }


    /*
    public function findOneBySomeField($value): ?Initiative
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
