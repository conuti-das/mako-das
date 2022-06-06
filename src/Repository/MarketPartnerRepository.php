<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\MarketPartner;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class MarketPartnerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MarketPartner::class);
    }

    public function add(MarketPartner $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function getById(int $id): ?MarketPartner
    {
        $data =  $this->getEntityManager()->find(MarketPartner::class, $id);
        if ($data instanceof MarketPartner) {
            return $data;
        }

        return null;
    }

    public function remove(MarketPartner $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
