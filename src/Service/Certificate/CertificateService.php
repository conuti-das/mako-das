<?php

declare(strict_types=1);

namespace App\Service\Certificate;

use App\Dto\Certificate\CertificateDto;
use App\Exception\Certificate\CertificateEmptyException;
use App\Exception\Certificate\CertificateParseException;
use App\Exception\Certificate\CertificateReadException;
use DateTime;
use OpenSSLCertificate;

class CertificateService
{
    /**
     * @throws CertificateEmptyException
     * @throws CertificateReadException
     * @throws CertificateParseException
     * @throws \Exception
     */
    public function decode(string $certificate): CertificateDto
    {
        if (empty($certificate)) {
            throw new CertificateEmptyException('Given certificate is empty.');
        }

        $decodedCertificate = openssl_x509_read($certificate);
        if (!$decodedCertificate instanceof OpenSSLCertificate) {
            throw new CertificateReadException('Given certificate could not be read.');
        }

        $decodedCertificateData = openssl_x509_parse($decodedCertificate);
        if (empty($decodedCertificateData)) {
            throw new CertificateParseException('Given certificate could not be parsed.');
        }

        $certificateDto = new CertificateDto();
        $certificateDto->setHash($decodedCertificateData['hash']);
        $certificateDto->setName($decodedCertificateData['name']);
        $certificateDto->setSerialNumber($decodedCertificateData['serialNumber']);
        $certificateDto->setEmailAddress($decodedCertificateData['subject']['emailAddress']);
        $certificateDto->setSubjectName($decodedCertificateData['subject']['CN']);
        $certificateDto->setSubjectOrganisation($decodedCertificateData['subject']['O']);
        $certificateDto->setSubjectLocation($decodedCertificateData['subject']['L']);
        $certificateDto->setSubjectCountry($decodedCertificateData['subject']['C']);
        $certificateDto->setIssuerName($decodedCertificateData['issuer']['CN']);
        $certificateDto->setIssuerOrganisation($decodedCertificateData['issuer']['O']);
        $certificateDto->setIssuerOrganisationUnit($decodedCertificateData['issuer']['OU']);
        $certificateDto->setIssuerCountry($decodedCertificateData['issuer']['C']);
        $certificateDto->setValidFrom((new DateTime)->setTimestamp((int)$decodedCertificateData['validFrom_time_t']));
        $certificateDto->setValidUntil((new DateTime)->setTimestamp((int)$decodedCertificateData['validTo_time_t']));

        return $certificateDto;
    }
}
