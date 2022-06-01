<?php

declare(strict_types=1);

namespace App\Service\Certificate;

use App\Exception\Certificate\CertificateUploadException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Exception;

class UploadService
{
    /**
     * @param UploadedFile $file
     * @param string $directoryName
     *
     * @return string
     * @throws CertificateUploadException
     */
    public function upload(UploadedFile $file, string $directoryName): string
    {
        try {
            $fileName = $this->generateName($file->getClientOriginalName());
            $file->move($directoryName, $fileName);

            return file_get_contents($directoryName . '/' . $fileName);
        } catch (Exception $exception) {
            throw new CertificateUploadException('Given certificate could not be uploaded.');
        }
    }

    public function generateName(string $originalName): string
    {
        return uniqid('', true) . '-' . $originalName;
    }
}
