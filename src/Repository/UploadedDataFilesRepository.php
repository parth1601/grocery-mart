<?php

namespace App\Repository;

use App\Entity\UploadedDataFiles;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method UploadedDataFiles|null find($id, $lockMode = null, $lockVersion = null)
 * @method UploadedDataFiles|null findOneBy(array $criteria, array $orderBy = null)
 * @method UploadedDataFiles[]    findAll()
 * @method UploadedDataFiles[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UploadedDataFilesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UploadedDataFiles::class);
    }

    // /**
    //  * @return UploadedDataFiles[] Returns an array of UploadedDataFiles objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?UploadedDataFiles
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
