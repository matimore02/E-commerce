<?php

namespace App\Repository;

use App\Entity\ProduitToDiy;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ProduitToDiy>
 *
 * @method ProduitToDiy|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProduitToDiy|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProduitToDiy[]    findAll()
 * @method ProduitToDiy[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProduitToDiyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProduitToDiy::class);
    }

//    /**
//     * @return ProduitToDiy[] Returns an array of ProduitToDiy objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ProduitToDiy
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
