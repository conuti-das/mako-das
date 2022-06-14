<?php

declare(strict_types=1);

namespace App\Service\Certificate;

class CertificateConverter
{
    public function convertDER2PEM(string $derData): string
    {
        $pem = chunk_split(base64_encode($derData), 64, "\n");

        return "-----BEGIN CERTIFICATE-----\n" . $pem . "-----END CERTIFICATE-----\n";
    }

    public function convertPEM2DER(string $pemData): string
    {
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
        $convertedToPEM = $this->convertDER2PEM($certificate);
        $convertedToDER = $this->convertPEM2DER($convertedToPEM);

        return md5($certificate) === md5($convertedToDER);
    }
}
