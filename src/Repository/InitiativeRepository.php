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
            ->orWhere('i.keywords LIKE :val2')
            ->setParameter('val2', '%' . $value . '%')
            ->getQuery()
            ->getResult();
    }

    public function findWhereNoteHigh()
    {
        $sql = "SELECT COUNT(initiative_id) AS likes, initiative_id FROM initiative_consumer 
        GROUP BY initiative_id ORDER BY likes DESC LIMIT 2";
        $conn = $this->getEntityManager()->getConnection();
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $initiatives = $stmt->fetchAll();
        $results = [];
        foreach ($initiatives as $current) {
            $results [] = $this->find($current["initiative_id"]);
        }
        dump($results);
        return $results;
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
