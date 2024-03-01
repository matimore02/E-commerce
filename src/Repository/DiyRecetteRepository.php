<?php

namespace App\Repository;

use App\Entity\DiyRecette;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DiyRecette>
 *
 * @method DiyRecette|null find($id, $lockMode = null, $lockVersion = null)
 * @method DiyRecette|null findOneBy(array $criteria, array $orderBy = null)
 * @method DiyRecette[]    findAll()
 * @method DiyRecette[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DiyRecetteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DiyRecette::class);
    }

//    /**
//     * @return DiyRecette[] Returns an array of DiyRecette objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('d.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?DiyRecette
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
