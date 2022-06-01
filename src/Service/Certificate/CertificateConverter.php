<?php

declare(strict_types=1);

namespace App\Service\Certificate;

use App\Exception\Certificate\CertificateWrongFormatException;

class CertificateConverter
{
    /**
     * @throws CertificateWrongFormatException
     */
    public function convertDER2PEM(string $derData): string
    {
        if (!$this->isDER($derData)) {
            throw new CertificateWrongFormatException('Given certificate is not in DER format.');
        }

        $pem = chunk_split(base64_encode($derData), 64, "\n");

        return "-----BEGIN CERTIFICATE-----\n" . $pem . "-----END CERTIFICATE-----\n";
    }

    /**
     * @throws CertificateWrongFormatException
     */
    public function convertPEM2DER(string $pemData): string
    {
        if (!$this->isPEM($pemData)) {
            throw new CertificateWrongFormatException('Given certificate is not in PEM format.');
        }

        $begin = "CERTIFICATE-----";
        $end = "-----END";
        $pemData = substr($pemData, strpos($pemData, $begin) + strlen($begin));
        $pemData = substr($pemData, 0, strpos($pemData, $end));

        return base64_decode($pemData);
    }

    public function isPEM(string $certificate): bool
    {
        return str_contains($certificate, '-----BEGIN CERTIFICATE-----')
            && str_contains($certificate, '-----END CERTIFICATE-----');
    }

    public function isDER(string $certificate): bool
    {
        $certificate = base64_encode($certificate);

        return str_contains($certificate, 'CERTIFICATE-----')
            && str_contains($certificate, '-----END');
    }
}
