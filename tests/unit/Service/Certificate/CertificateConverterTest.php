<?php

declare(strict_types=1);

namespace App\Tests\unit\Service\Certificate;

use App\Service\Certificate\CertificateConverter;
use App\Tests\UnitTester;
use Codeception\Test\Unit;

class CertificateConverterTest extends Unit
{
    protected UnitTester $tester;
    private string $certificatePEM;
    private string $certificateDER;
    private CertificateConverter $certificateConverter;

    protected function _before(): void
    {
        $this->certificateConverter = $this->tester->grabService(CertificateConverter::class);
        $this->certificatePEM = file_get_contents(codecept_data_dir() . 'Certificate/4033872000010.cer.pem');
        $this->certificateDER = file_get_contents(codecept_data_dir() . 'Certificate/4033872000010.cer.der');
    }

    /**
     * @covers \App\Service\Certificate\CertificateConverter::isPEM
     */
    public function testIsPEM(): void
    {
        $this->tester->assertTrue($this->certificateConverter->isPEM($this->certificatePEM));
    }

    /**
     * @covers \App\Service\Certificate\CertificateConverter::isDER
     */
    public function testIsDER(): void
    {
        $this->tester->assertTrue($this->certificateConverter->isDER($this->certificateDER));
    }

    /**
     * @covers \App\Service\Certificate\CertificateConverter::convertPEM2DER
     */
    public function testConvertPEM2DER(): void
    {
        $convertedDER = $this->certificateConverter->convertPEM2DER($this->certificatePEM);

        $this->tester->assertEquals($this->certificateDER, $convertedDER);
    }

    /**
     * @covers \App\Service\Certificate\CertificateConverter::convertDER2PEM
     */
    public function testConvertDER2PEM(): void
    {
        $convertedPEM = $this->certificateConverter->convertDER2PEM($this->certificateDER);

        $this->tester->assertEquals($this->certificatePEM, $convertedPEM);
    }
}
