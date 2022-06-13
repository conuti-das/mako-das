<?php

declare(strict_types=1);

namespace App\Tests\unit\Service\Certificate;

use App\Exception\Certificate\CertificateEmptyException;
use App\Exception\Certificate\CertificateParseException;
use App\Exception\Certificate\CertificateReadException;
use App\Service\Certificate\CertificateService;
use App\Tests\UnitTester;
use Codeception\Test\Unit;
use DateTime;
use JsonException;

class CertificateServiceTest extends Unit
{
    protected UnitTester $tester;
    private string $certificatePEM;
    private string $certificateDER;
    private CertificateService $certificateService;

    protected function _before(): void
    {
        $this->certificateService = $this->tester->grabService(CertificateService::class);
        $this->certificatePEM = file_get_contents(codecept_data_dir() . 'Certificate/9911620000000.cer.pem');
        $this->certificateDER = file_get_contents(codecept_data_dir() . 'Certificate/4033872000010.cer.der');
    }

    /**
     * @covers \App\Service\Certificate\CertificateService::decode
     */
    public function testDecodePEMCertificate(): void
    {
        $certificateDto = $this->certificateService->decode($this->certificatePEM);

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

    /**
     * @covers \App\Service\Certificate\CertificateService::decode
     */
    public function testDecodeDERCertificate(): void
    {
        $certificateDto = $this->certificateService->decode($this->certificateDER);

        $this->tester->assertEquals(
            '/emailAddress=vnb@tennet.biz/C=DE/ST=Bayern/L=Bayreuth/O=TenneT TSO GmbH/SN=tennet.biz/GN=vnb/CN=vnb',
            $certificateDto->getName()
        );
        $this->tester->assertEquals('70efd0c3', $certificateDto->getHash());
        $this->tester->assertEquals('0x2AF01FD8F9508EC2EAAEEDA33B85CFFB28E590C5', $certificateDto->getSerialNumber());
        $this->tester->assertEquals('vnb@tennet.biz', $certificateDto->getEmailAddress());
        $this->tester->assertEquals('vnb', $certificateDto->getSubjectName());
        $this->tester->assertEquals('TenneT TSO GmbH', $certificateDto->getSubjectOrganisation());
        $this->tester->assertEquals('Bayreuth', $certificateDto->getSubjectLocation());
        $this->tester->assertEquals('DE', $certificateDto->getSubjectCountry());
        $this->tester->assertEquals('QuoVadis Europe Advanced CA G2', $certificateDto->getIssuerName());
        $this->tester->assertEquals('QuoVadis Trustlink Deutschland GmbH', $certificateDto->getIssuerOrganisation());
        $this->tester->assertEquals(null, $certificateDto->getIssuerOrganisationUnit());
        $this->tester->assertEquals('DE', $certificateDto->getIssuerCountry());
        $this->tester->assertEquals('2020-09-16 09:42:14', $certificateDto->getValidFrom()->format('Y-m-d H:i:s'));
        $this->tester->assertEquals('2023-03-20 00:00:00', $certificateDto->getValidUntil()->format('Y-m-d H:i:s'));
    }

    public function testCertificateIsActive(): void
    {
        $nowDate = new DateTime('now');
        $certificateDto = $this->certificateService->decode($this->certificatePEM);

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

    /**
     * @throws JsonException
     * @throws CertificateEmptyException
     * @throws CertificateParseException
     * @throws CertificateReadException
     */
    public function testJsonRepresentation(): void
    {
        $nowDate = new DateTime('2022-05-18 14:55:55');
        $certificateDto = $this->certificateService->decode($this->certificatePEM);

        // modify the dates to be active everytime
        $newActiveFrom = clone $nowDate;
        $certificateDto->setValidFrom($newActiveFrom->modify('-2 months'));
        $newActiveUntil = clone $nowDate;
        $certificateDto->setValidUntil($newActiveUntil->modify('+2 months'));

        $this->tester->assertJsonStringEqualsJsonString(
            '{"name":"\/emailAddress=bes_vertrieb@bigge-energie.de\/CN=bes_vertrieb\/O=BIGGE Energie GmbH & Co. KG\/L=Attendorn\/C=DE","hash":"6b7f2420","serialNumber":"0x056C0E37A7984B3DC3AB73EB3411988D49C2460A","emailAddress":"bes_vertrieb@bigge-energie.de","validFrom":{"date":"2022-03-18 14:55:55.000000","timezone_type":3,"timezone":"UTC"},"validUntil":{"date":"2022-07-18 14:55:55.000000","timezone_type":3,"timezone":"UTC"},"subjectName":"bes_vertrieb","subjectOrganisation":"BIGGE Energie GmbH & Co. KG","subjectLocation":"Attendorn","subjectCountry":"DE","issuerName":"procilon GROUP Customer CA - EDIFACT 03","issuerOrganisation":"SPI-CLOUD","issuerOrganisationUnit":"Sub CA","issuerCountry":"DE","certificateFile":"LS0tLS1CRUdJTiBDRVJUSUZJQ0FURS0tLS0tDQpNSUlIU2pDQ0JQNmdBd0lCQWdJVUJXd09ONmVZU3ozRHEzUHJOQkdZalVuQ1Jnb3dRUVlKS29aSWh2Y05BUUVLDQpNRFNnRHpBTkJnbGdoa2dCWlFNRUFnTUZBS0VjTUJvR0NTcUdTSWIzRFFFQkNEQU5CZ2xnaGtnQlpRTUVBZ01GDQpBS0lEQWdGQU1HUXhNREF1QmdOVkJBTU1KM0J5YjJOcGJHOXVJRWRTVDFWUUlFTjFjM1J2YldWeUlFTkJJQzBnDQpSVVJKUmtGRFZDQXdNekVQTUEwR0ExVUVDd3dHVTNWaUlFTkJNUkl3RUFZRFZRUUtEQWxUVUVrdFEweFBWVVF4DQpDekFKQmdOVkJBWVRBa1JGTUI0WERUSXlNRFF4TkRFME16STBObG9YRFRJMU1EUXhNekUwTXpJME5Wb3dnWXd4DQpMREFxQmdrcWhraUc5dzBCQ1FFV0hXSmxjMTkyWlhKMGNtbGxZa0JpYVdkblpTMWxibVZ5WjJsbExtUmxNUlV3DQpFd1lEVlFRRERBeGlaWE5mZG1WeWRISnBaV0l4SkRBaUJnTlZCQW9NRzBKSlIwZEZJRVZ1WlhKbmFXVWdSMjFpDQpTQ0FtSUVOdkxpQkxSekVTTUJBR0ExVUVCd3dKUVhSMFpXNWtiM0p1TVFzd0NRWURWUVFHRXdKRVJUQ0NBaUl3DQpEUVlKS29aSWh2Y05BUUVCQlFBRGdnSVBBRENDQWdvQ2dnSUJBTVVLVVdjTFlGZEJZYXNubUV0cnczMUFIbUhTDQpZWFkxNnF0L3c2UG1EazI2YWExRDRsdjNVWkcwSXdGeU5LRXRKblJ0NHpkOUZxWFJNMHhKdWc2RkhTekphUFRIDQpBMVdoV3dNZ1hmZG00SG15UDg3UG03VzR5dGh4YlhzRUxVWm52VmcyV0pPYlUxRTBUQUQ3ZkR3TStqVDJ6bHA4DQpoZjNnQmdUNXE5eWpFaS9HbjM0THFTLy9Cc2RVTEx4b2xSSk9kNDEwc2RnOW1vUTR1d3ViS01sRkZnT1ZrSHl6DQpUc0UyWGJBeUpkYTdURlk5Sm9mSnNLUzl1Q3dhS2ViWUpSUWFhckd5dEViZ1ZwTjlyc2hpRE02TmRUVW9mZmc1DQplK0k1ZnV0a1QyeldPYzdGNDVVZ3BEMytrdnZvTU9lWk9BTWhNSHBpZWtUVTZ3M0FRQkVJODkyNXd0RDBCNE5tDQplK0RrUXFaU0JQTzVNdVlyL2lmcWdYU25ORWNoYTAyNjJMZk56bUM5NFpEWGR3b2E1bGU4RlMvb2I2cGxRR2w0DQpZUXdsWUtzUjZFQXJYNWY5azdqblZNQi8yTFhwL0RZNEhFbHNSWkphazNhd2dGUm9HN3FCbXB1Z2lCenNnaFdiDQpCTUhTTmxhcnFRSjc4bjlXQngxeDM1MGRkamkvYkVBVDVtTWtaTXV6ZnlReGNPeE5Ja1FTZXptUDFEUFEzUTRLDQpORksyYVExdW0xVjNiWEFQTHpZSzBQY3VLUDF1cEdHNWdXQWF3dHdjZ0JQN0RMWmZUb1RvOCtXdnRNNndvZk9rDQo1UVFtOXJ2YjB6RjJ5S0htUjgxTTJOSlFaT3lySGp6bzdnOFQyeVQrRXhxdXpQdXkrMWtLV3g1REVkLzd5SkpzDQplbUNFL1BlR3VYZTF4MDB4QWdNQkFBR2pnZ0ZoTUlJQlhUQU1CZ05WSFJNQkFmOEVBakFBTUI4R0ExVWRJd1FZDQpNQmFBRkVSRTc1am5GT2hOMXBMSUgvbnpaOWJrK0JtcE1Ha0dDQ3NHQVFVRkJ3RUJCRjB3V3pBcUJnZ3JCZ0VGDQpCUWN3QW9ZZWFIUjBjSE02THk5d2Eya3VjSEp2ZEdWamRISXVaR1V2YVhOemRXVnlNQzBHQ0NzR0FRVUZCekFCDQpoaUZvZEhSd09pOHZiMk56Y0M1emNHa3RZMnh2ZFdRdVkyOXRMM04wWVhSMWN5OHdLQVlEVlIwUkJDRXdINEVkDQpZbVZ6WDNabGNuUnlhV1ZpUUdKcFoyZGxMV1Z1WlhKbmFXVXVaR1V3RXdZRFZSMGxCQXd3Q2dZSUt3WUJCUVVIDQpBd1F3VXdZRFZSMGZCRXd3U2pCSW9FYWdSSVpDYUhSMGNEb3ZMM0JyYVM1emNHa3RZMnh2ZFdRdVkyOXRMMk55DQpiQzl3Y205amFXeHZibDlIVWs5VlVGOURkWE4wYjIxbGNsOURRVjlGUkVsR1FVTlVYekF6TUIwR0ExVWREZ1FXDQpCQlJlTFR3MzNianJuODlDR25pWXZRdmgvYjdZZXpBT0JnTlZIUThCQWY4RUJBTUNCTEF3UVFZSktvWklodmNODQpBUUVLTURTZ0R6QU5CZ2xnaGtnQlpRTUVBZ01GQUtFY01Cb0dDU3FHU0liM0RRRUJDREFOQmdsZ2hrZ0JaUU1FDQpBZ01GQUtJREFnRkFBNElDQVFCT0pGdjhPY3h1dTJEOUorQy9zYTRnQTQ1WkUxVXNmV1JYMWc2cVFra1R4QWhRDQpsWlpiVkFmMG1UL3BrQXJZV0c1TGFVSUpxa3N1eVB3V1Q3ZDQwR3VWbVVtVFdNM2JEOThkdFE3MU5wTUVOaGdhDQpLL1dUVlNCRkltMFZWYW0yRG5iU0pKNDBJWVhvb1E5U2o2S3RIdFNHNlhtVGFwMVdvNitoTERwaGNKZDY1TkkwDQo5S2FNMGtPcFFCYVMwdUtUZTJkODNGdkZWS0J6SVJKZCt1ZTBjRGxVU2xtN3B3YlVFa0hhUU0zTVRBSkI2dGdHDQpSRnc4R1hDanl2eEJyZ2docDlEWkowdmtUNjh1ZFpOcFNZRTFMNGJMV2twRVVWUVlib2dSZ1JpbWk2TkxYY1A3DQpJQTJ4V0ZWNU83aU9aKytKU1FyMWVPQUVaWTFxVkV2MjBIUmJITGpsbVZLVUMzWGdQbENTRm1lakgzSk9qVGcyDQo0WFptWGVkUlhpV3NYTEdSaWN1N2JzRTQ3SVptODNmMEp5TlpCais0Vk1NS3VYMTR0KzVQZ3lTak1tN3dCeUtGDQorVnJUWXVEeE5sTU9INXBpVlZmY0tZT2pwb0dJSXowUkd4bUxsVVM2b3J5TExvcThkTzd4Zy96Y1pNdHpxL0pODQpXRGtWQzNEOGxkSXpIT0doZGlJdndnUGZMMHMvRENNTHVsVTc5MjM3Wjd1QWJja0U4WGR5MllQbjdpZjJ0REh4DQpjQVpsRmxoVndRbGVyZHU5Vi8rSFVjeHhBSXF5WXExZGNiSDJGVG8wcGJFYmZpMGtXU0F2blg5bmhUczBXQlZLDQpUUXg2cmFENVoyb3htLzFiN0ZURmNGb0N1NVc4YktSbHFQRlN0VG52ZElwZEJsZGNVUUVsV3BoZVBHNk1mUT09DQotLS0tLUVORCBDRVJUSUZJQ0FURS0tLS0tDQo=","isActive":true}',
            $certificateDto->toJson()
        );
    }

    /**
     * @throws CertificateReadException
     * @throws CertificateParseException
     */
    public function testCertificateEmptyException(): void
    {
        $this->expectException(CertificateEmptyException::class);

        $this->certificateService->decode('');
    }

    /**
     * @throws CertificateEmptyException
     * @throws CertificateParseException
     */
    public function testCertificateReadException(): void
    {
        $this->expectException(CertificateReadException::class);

        $this->certificateService->decode('---------');
    }
}
