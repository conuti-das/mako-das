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
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\Translation\TranslatorInterface;

class CertificateControllerTest extends Unit
{
    private const PARTNER_ID = 0;

    protected UnitTester $tester;
    private CertificateController $certificateController;

    public function _before(): void
    {
        $marketPartnerRepository = $this->createMock(MarketPartnerRepository::class);
        $marketPartnerRepository->method("find")->with(self::PARTNER_ID)->willReturn(null);

        $translator = $this->createMock(TranslatorInterface::class);
        $translator->expects($this->any())->method('trans')->willReturn("I cant find the Market Partner");

        $this->certificateController = new CertificateController(
            $this->createMock(MarketPartnerEmailRepository::class),
            $this->createMock(UploadService::class),
            $this->createMock(CertificateService::class),
            $marketPartnerRepository,
            $translator
        );

    }

    /**
     * @throws Exception
     */
    public function testCheckMarketPartnerIdException(): void
    {
        $request = $this->createMock(Request::class);
        $request->method("get")->with("partnerId")->willReturn(self::PARTNER_ID);
        $response = $this->certificateController->certificateDecode($request);
        $this->tester->assertEquals(new JsonResponse(['errorMessage' => "I cant find the Market Partner"]), $response);
    }
}
