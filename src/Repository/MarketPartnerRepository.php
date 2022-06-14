<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\MarketPartner;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;

class MarketPartnerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MarketPartner::class);
    }

    /**
     * @throws NonUniqueResultException
     */
    public function getActiveMarketPartner($partnerId): ?MarketPartner
    {
        return $this->createQueryBuilder('mp')
            ->where('mp.partnerId', $partnerId)
            ->andWhere('mp.active', 1)
            ->andWhere('mp.deleted', 0)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function add(MarketPartner $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(MarketPartner $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
