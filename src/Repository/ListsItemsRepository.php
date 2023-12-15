<?php

namespace App\Repository;

use App\Entity\ListsItems;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ListsItems>
 *
 * @method ListsItems|null find($id, $lockMode = null, $lockVersion = null)
 * @method ListsItems|null findOneBy(array $criteria, array $orderBy = null)
 * @method ListsItems[]    findAll()
 * @method ListsItems[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ListsItemsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ListsItems::class);
    }

//    /**
//     * @return ListsItems[] Returns an array of ListsItems objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('l.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ListsItems
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
