<?php

declare(strict_types=1);

namespace App\Repository;

use App\Dto\Certificate\CertificateDtoInterface;
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

    public function addCertificate(CertificateDtoInterface $uploadCertificateDto, bool $flush = false): MarketPartnerEmail
    {
        $marketPartnerEmail = new MarketPartnerEmail();

        $marketPartnerEmail->setMarketPartner($uploadCertificateDto->getMarketPartner());
        $marketPartnerEmail->setCreatedAt(new DateTime('now'));
        $marketPartnerEmail->setUpdatedAt(new DateTime('now'));
        $marketPartnerEmail->setEmail($uploadCertificateDto->getEmailAddress());
        $marketPartnerEmail->setType($marketPartnerEmail::TYPE_EDIFACT);
        $marketPartnerEmail->setSslCertificate($uploadCertificateDto->getCertificateFile());
        $marketPartnerEmail->setSslCertificateExpiration($uploadCertificateDto->getValidUntil());
        $marketPartnerEmail->setActiveFrom($uploadCertificateDto->getValidUntil());
        $marketPartnerEmail->setActiveUntil($uploadCertificateDto->getValidFrom());

        $this->getEntityManager()->persist($marketPartnerEmail);

        if ($flush) {
            $this->getEntityManager()->flush();
        }

        return $marketPartnerEmail;
    }

    public function remove(MarketPartnerEmail $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
