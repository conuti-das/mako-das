<?php

namespace App\Repository;

use App\Entity\MarketPartner;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<MarketPartner>
 *
 * @method MarketPartner|null find($id, $lockMode = null, $lockVersion = null)
 * @method MarketPartner|null findOneBy(array $criteria, array $orderBy = null)
 * @method MarketPartner[]    findAll()
 * @method MarketPartner[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
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

    public function remove(MarketPartner $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
