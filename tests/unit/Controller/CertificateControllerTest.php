<?php

declare(strict_types=1);

namespace App\Tests\unit\Controller;

use App\Controller\Admin\CertificateController;
use App\Repository\MarketPartnerEmailRepository;
use App\Repository\MarketPartnerRepository;
use App\Service\Certificate\CertificateService;
use App\Service\Upload\UploadService;
use App\Tests\UnitTester;
use Codeception\Test\Unit;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class CertificateControllerTest extends Unit
{
    private const PARTNER_ID = 0;

    protected UnitTester $tester;
    private CertificateController $certificateController;

    public function _before(): void
    {
        $marketPartnerRepository = $this->createMock(MarketPartnerRepository::class);
        $marketPartnerRepository->method("find")->with(self::PARTNER_ID)->willReturn(null);

        $this->certificateController = new CertificateController(
            $this->createMock(MarketPartnerEmailRepository::class),
            $this->createMock(UploadService::class),
            $this->createMock(CertificateService::class),
            $marketPartnerRepository
        );
    }

    public function testCheckMarketPartnerIdException(): void
    {
        $this->certicateControler = $this->tester->grabService(CertificateController::class);
        $request = $this->createMock(Request::class);

        $request->method("get")->with("partnerId")->willReturn(self::PARTNER_ID);

        $response = $this->certificateController->certificateDecode($request);

        $this->assertEquals(new JsonResponse(['errorMessage' => "Given Market partnerId didn't exist"]), $response);
    }
}
