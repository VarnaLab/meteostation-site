<?php

namespace App\Repository;

use App\Entity\StationData;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<StationData>
 *
 * @method StationData|null find($id, $lockMode = null, $lockVersion = null)
 * @method StationData|null findOneBy(array $criteria, array $orderBy = null)
 * @method StationData[]    findAll()
 * @method StationData[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StationDataRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StationData::class);
    }

    public function add(StationData $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(StationData $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
