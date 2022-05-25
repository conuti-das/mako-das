<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\MarketPartnerEmail;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class MarketPartnerEmailRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MarketPartnerEmail::class);
    }

    public function addCertificate($entity, $uploadCertificateDto, bool $flush = false)
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $entity->setMarketPartnerId($uploadCertificateDto->getPartnerId());
            $entity->setCreatedAt(new DateTime('now'));
            $entity->setEmail($uploadCertificateDto->getEmailAddress());
            $entity->setType($entity::TYPE_EDIFACT);
            $entity->setSslCertificate($uploadCertificateDto->getCertificateFile());
            $entity->setSslCertificateExpiration($uploadCertificateDto->getValidUntil());
            $entity->setActiveFrom($uploadCertificateDto->getValidUntil());
            $entity->setActiveUntil($uploadCertificateDto->getValidFrom());
            $this->getEntityManager()->flush();

            return $entity;
        }
    }

    public function remove(MarketPartnerEmail $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
