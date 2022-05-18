<?php

declare(strict_types=1);

namespace App\Tests\unit\Service\Certificate;

use App\Exception\Certificate\CertificateEmptyException;
use App\Exception\Certificate\CertificateReadException;
use App\Service\Certificate\CertificateService;
use App\Tests\UnitTester;
use Codeception\Test\Unit;
use DateTime;

class CertificateServiceTest extends Unit
{
    protected UnitTester $tester;
    private string $certificate;

    protected function _before()
    {
        $this->certificate = file_get_contents(codecept_data_dir() . 'Certificate/9911620000000.cer');
    }

    /**
     * @covers \App\Service\Certificate\CertificateService::decode
     */
    public function testDecodeCertificate(): void
    {
        $certificateService = new CertificateService();
        $certificateDto = $certificateService->decode($this->certificate);

        $this->tester->assertEquals(
            '/emailAddress=bes_vertrieb@bigge-energie.de/CN=bes_vertrieb/O=BIGGE Energie GmbH & Co. KG/L=Attendorn/C=DE',
            $certificateDto->getName()
        );
        $this->tester->assertEquals('6b7f2420', $certificateDto->getHash());
        $this->tester->assertEquals('0x056C0E37A7984B3DC3AB73EB3411988D49C2460A', $certificateDto->getSerialNumber());
        $this->tester->assertEquals('bes_vertrieb@bigge-energie.de', $certificateDto->getEmailAddress());
        $this->tester->assertEquals('bes_vertrieb', $certificateDto->getSubjectName());
        $this->tester->assertEquals('BIGGE Energie GmbH & Co. KG', $certificateDto->getSubjectOrganisation());
        $this->tester->assertEquals('Attendorn', $certificateDto->getSubjectLocation());
        $this->tester->assertEquals('DE', $certificateDto->getSubjectCountry());
        $this->tester->assertEquals('procilon GROUP Customer CA - EDIFACT 03', $certificateDto->getIssuerName());
        $this->tester->assertEquals('SPI-CLOUD', $certificateDto->getIssuerOrganisation());
        $this->tester->assertEquals('Sub CA', $certificateDto->getIssuerOrganisationUnit());
        $this->tester->assertEquals('DE', $certificateDto->getIssuerCountry());
        $this->tester->assertEquals('2022-04-14 14:32:46', $certificateDto->getValidFrom()->format('Y-m-d H:i:s'));
        $this->tester->assertEquals('2025-04-13 14:32:45', $certificateDto->getValidUntil()->format('Y-m-d H:i:s'));
    }

    public function testCertificateIsActive(): void
    {
        $nowDate = new DateTime('now');

        $certificateService = new CertificateService();
        $certificateDto = $certificateService->decode($this->certificate);

        // modify the dates: 1
        $newActiveFrom = clone $nowDate;
        $certificateDto->setValidFrom($newActiveFrom->modify('-2 months'));
        $newActiveUntil = clone $nowDate;
        $certificateDto->setValidUntil($newActiveUntil->modify('+2 months'));
        $this->tester->assertTrue($certificateDto->isActive());

        // modify the dates: 2
        $newActiveFrom = clone $nowDate;
        $certificateDto->setValidFrom($newActiveFrom->modify('+2 months'));
        $newActiveUntil = clone $nowDate;
        $certificateDto->setValidUntil($newActiveUntil->modify('+4 months'));
        $this->tester->assertFalse($certificateDto->isActive());

        // modify the dates: 3
        $newActiveFrom = clone $nowDate;
        $certificateDto->setValidFrom($newActiveFrom->modify('-4 months'));
        $newActiveUntil = clone $nowDate;
        $certificateDto->setValidUntil($newActiveUntil->modify('-2 months'));
        $this->tester->assertFalse($certificateDto->isActive());
    }

    public function testJsonRepresentation(): void
    {
        $nowDate = new DateTime('2022-05-18 14:55:55');

        $certificateService = new CertificateService();
        $certificateDto = $certificateService->decode($this->certificate);

        // modify the dates to be active everytime
        $newActiveFrom = clone $nowDate;
        $certificateDto->setValidFrom($newActiveFrom->modify('-2 months'));
        $newActiveUntil = clone $nowDate;
        $certificateDto->setValidUntil($newActiveUntil->modify('+2 months'));

        $this->tester->assertJsonStringEqualsJsonString(
            '{"name":"\/emailAddress=bes_vertrieb@bigge-energie.de\/CN=bes_vertrieb\/O=BIGGE Energie GmbH & Co. KG\/L=Attendorn\/C=DE","hash":"6b7f2420","serialNumber":"0x056C0E37A7984B3DC3AB73EB3411988D49C2460A","emailAddress":"bes_vertrieb@bigge-energie.de","validFrom":{"date":"2022-03-18 14:55:55.000000","timezone_type":3,"timezone":"UTC"},"validUntil":{"date":"2022-07-18 14:55:55.000000","timezone_type":3,"timezone":"UTC"},"subjectName":"bes_vertrieb","subjectOrganisation":"BIGGE Energie GmbH & Co. KG","subjectLocation":"Attendorn","subjectCountry":"DE","issuerName":"procilon GROUP Customer CA - EDIFACT 03","issuerOrganisation":"SPI-CLOUD","issuerOrganisationUnit":"Sub CA","issuerCountry":"DE","isActive":true}',
            $certificateDto->toJson()
        );
    }

    public function testCertificateEmptyException(): void
    {
        $this->expectException(CertificateEmptyException::class);

        $certificateService = new CertificateService();
        $certificateService->decode('');
    }

    public function testCertificateReadException(): void
    {
        $this->expectException(CertificateReadException::class);

        $certificateService = new CertificateService();
        $certificateService->decode('---------');
    }
}
