<?php

namespace App\Repository;

use App\Entity\HorarioRestaurante;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<HorarioRestaurante>
 *
 * @method HorarioRestaurante|null find($id, $lockMode = null, $lockVersion = null)
 * @method HorarioRestaurante|null findOneBy(array $criteria, array $orderBy = null)
 * @method HorarioRestaurante[]    findAll()
 * @method HorarioRestaurante[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HorarioRestauranteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, HorarioRestaurante::class);
    }

    public function add(HorarioRestaurante $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(HorarioRestaurante $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return HorarioRestaurante[] Returns an array of HorarioRestaurante objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('h')
//            ->andWhere('h.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('h.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?HorarioRestaurante
//    {
//        return $this->createQueryBuilder('h')
//            ->andWhere('h.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
