<?php

declare(strict_types=1);

namespace App\Service\Import;

use App\Common\FileReader;
use App\Entity\MarketPartnerEmailImportLog;
use App\Entity\MarketPartnerImportLog;
use App\Factory\MarketPartnerFactory;
use App\Repository\MarketPartnerEmailImportLogRepository;
use App\Repository\MarketPartnerEmailRepository;
use App\Repository\MarketPartnerImportLogRepository;
use App\Repository\MarketPartnerRepository;
use App\Service\Certificate\CertificateService;
use DateTime;
use Exception;

class ImportMarketPartnerService
{
    public const FILE_EXTENSION = ".cer.converted";

    public function __construct(
        private CertificateService $certificateService,
        private FileReader $fileReader,
        private MarketPartnerFactory $marketPartnerFactory,
        private MarketPartnerRepository $marketPartnerRepository,
        private MarketPartnerEmailRepository $partnerEmailRepository,
        private MarketPartnerEmailImportLogRepository $emailImportLogRepository,
        private MarketPartnerImportLogRepository $partnerImportLogRepository
    ) {
    }

    public function import(array $marketPartner, string $importPath): void
    {
        $newMarketPartner = null;
        try {
            $newMarketPartner = $this->marketPartnerFactory->createFromArray($marketPartner);
            $this->marketPartnerRepository->add($newMarketPartner);
            $marketPartnerLogStatus = MarketPartnerImportLog::STATUS_DONE;
            $marketPartnerLogException = null;
            $marketPartnerEmail = null;

            try {
                $filePath = $importPath. $marketPartner["partnerId"] . self::FILE_EXTENSION;

                $certificate = $this->certificateService->decode(
                    $this->fileReader->getContent($filePath)
                );

                $certificate->setMarketPartner($newMarketPartner);
                $marketPartnerEmail = $this->partnerEmailRepository->addCertificate($certificate);

                $certificateLogStatus = MarketPartnerEmailImportLog::STATUS_DONE;
                $certificateLogException = null;
            } catch (Exception $exception) {
                $certificateLogStatus = MarketPartnerEmailImportLog::STATUS_FAILED;
                $certificateLogException = $exception->getMessage();
            }

            $certificateLog = new MarketPartnerEmailImportLog();
            $certificateLog->setMarketPartnerEmail($marketPartnerEmail);
            $certificateLog->setMessage($certificateLogException);
            $certificateLog->setStatus($certificateLogStatus);
            $certificateLog->setCreatedAt(new DateTime('now'));
            $this->emailImportLogRepository->add($certificateLog);
        } catch (Exception $exception) {
            $marketPartnerLogStatus = MarketPartnerImportLog::STATUS_FAILED;
            $marketPartnerLogException = $exception->getMessage();
        }
        $partnerImportLog = new MarketPartnerImportLog();
        $partnerImportLog->setStatus($marketPartnerLogStatus);
        $partnerImportLog->setMarketPartner($newMarketPartner);
        $partnerImportLog->setCreatedAt(new DateTime("now"));
        $partnerImportLog->setMessage($marketPartnerLogException);

        $this->partnerImportLogRepository->add($partnerImportLog);
    }
}
