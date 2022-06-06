<?php

declare(strict_types=1);

namespace App\Service\Import;

use App\Service\Certificate\CertificateService;

class ImportMarketPartnerService
{
    public function __construct(private CertificateService $certificateService)
    {
    }

    public function importFromCsv(): void
    {

    }
}
