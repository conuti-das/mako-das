<?php

declare(strict_types=1);

namespace App\Service\Certificate;

use App\Exception\Certificate\CertificateParseException;
use App\Exception\Certificate\UploadCertificateException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Exception;

class UploadService
{
    /**
     * @param UploadedFile $file
     * @param string $directoryName
     *
     * @return string
     * @throws CertificateParseException
     * @throws UploadCertificateException
     */
    public function upload(UploadedFile $file, string $directoryName): string
    {
        try {
            $fileName = $this->generateName($file->getClientOriginalName());
            $file->move($directoryName, $fileName);
        } catch (Exception $exception) {
            throw new UploadCertificateException('Given certificate could not be uploaded.');
        }

        try {
            $uploadedCertificate = file_get_contents($directoryName . '/' . $fileName);

            return $uploadedCertificate;
        } catch (Exception $exception) {
            throw new CertificateParseException('Given certificate could not be parsed.');
        }
    }

    /**
     * @param string $originalName
     *
     * @return string
     */
    public function generateName(string $originalName): string
    {
        return uniqid() . '-' . $originalName;
    }
}
