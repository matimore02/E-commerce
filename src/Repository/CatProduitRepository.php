<?php

namespace App\Repository;

use App\Entity\CatProduit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CatProduit>
 *
 * @method CatProduit|null find($id, $lockMode = null, $lockVersion = null)
 * @method CatProduit|null findOneBy(array $criteria, array $orderBy = null)
 * @method CatProduit[]    findAll()
 * @method CatProduit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CatProduitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CatProduit::class);
    }

//    /**
//     * @return CatProduit[] Returns an array of CatProduit objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?CatProduit
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
