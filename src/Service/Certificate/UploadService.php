<?php

declare(strict_types=1);

namespace App\Service\Certificate;

use Exception;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Twig\Error\Error;

class UploadService
{
    /**
     * @param UploadedFile $file
     * @param $directoryName
     *
     * @return string
     * @throws Error
     */
    public function upload(UploadedFile $file, $directoryName): string
    {
        try {
            $certificateService = new CertificateService();
            $fileName = uniqid().'-'.$file->getClientOriginalName();
            $file->move($directoryName, $fileName);
            $uploaded_certificate = file_get_contents($directoryName.'/'.$fileName);
            $certificateService = $certificateService->decode($uploaded_certificate);
            $certificateService->setCertificateFile($uploaded_certificate);
            return $certificateService->toJson();
        } catch (Exception $exception) {
            throw new Error("This certificate cannot be loaded.");
        }
    }
}
