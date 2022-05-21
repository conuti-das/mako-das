<?php

declare(strict_types=1);

namespace App\Repository;

use App\Dto\Certificate\UploadCertificateDto;
use App\Entity\MarketPartnerEmail;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class MarketPartnerEmailRepository extends ServiceEntityRepository
{
    /**
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MarketPartnerEmail::class);
    }

    /**
     * @param UploadCertificateDto $uploadCertificateDto
     *
     * @return void
     */
    public function addCertificate(UploadCertificateDto $uploadCertificateDto): void
    {
        $marketPartnerEmail = new MarketPartnerEmail();
        $marketPartnerEmail->setMarketPartnerId($uploadCertificateDto->getPartnerId());
        $marketPartnerEmail->setCreatedAt(new DateTime('now'));
        $marketPartnerEmail->setEmail($uploadCertificateDto->getEmailAddress());
        $marketPartnerEmail->setType('edifact');
        $marketPartnerEmail->setSslCertificate($uploadCertificateDto->getCertificateFile());
        $marketPartnerEmail->setSslCertificateExpiration($uploadCertificateDto->getValidUntil());
        $marketPartnerEmail->setActiveFrom($uploadCertificateDto->getValidUntil());
        $marketPartnerEmail->setActiveUntil($uploadCertificateDto->getValidFrom());
        $this->getEntityManager()->persist($marketPartnerEmail);
        $this->getEntityManager()->flush();
    }

    public function remove(MarketPartnerEmail $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
