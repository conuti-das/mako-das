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
    public function JsonRepresentation(): void
    {
        $nowDate = new DateTime('2022-05-18 14:55:55');
        $certificateDto = $this->certificateService->decode($this->certificatePEM);

        // modify the dates to be active everytime
        $newActiveFrom = clone $nowDate;
        $certificateDto->setValidFrom($newActiveFrom->modify('-2 months'));
        $newActiveUntil = clone $nowDate;
        $certificateDto->setValidUntil($newActiveUntil->modify('+2 months'));

        $this->tester->assertJsonStringEqualsJsonString(
            '{"name":"\/emailAddress=bes_vertrieb@bigge-energie.de\/CN=bes_vertrieb\/O=BIGGE Energie GmbH & Co. KG\/L=Attendorn\/C=DE","hash":"6b7f2420","serialNumber":"0x056C0E37A7984B3DC3AB73EB3411988D49C2460A","emailAddress":"bes_vertrieb@bigge-energie.de","validFrom":{"date":"2022-03-18 14:55:55.000000","timezone_type":3,"timezone":"UTC"},"validUntil":{"date":"2022-07-18 14:55:55.000000","timezone_type":3,"timezone":"UTC"},"subjectName":"bes_vertrieb","subjectOrganisation":"BIGGE Energie GmbH & Co. KG","subjectLocation":"Attendorn","subjectCountry":"DE","issuerName":"procilon GROUP Customer CA - EDIFACT 03","issuerOrganisation":"SPI-CLOUD","issuerOrganisationUnit":"Sub CA","issuerCountry":"DE","certificateFile":"-----BEGIN CERTIFICATE-----\r\nMIIHSjCCBP6gAwIBAgIUBWwON6eYSz3Dq3PrNBGYjUnCRgowQQYJKoZIhvcNAQEK\r\nMDSgDzANBglghkgBZQMEAgMFAKEcMBoGCSqGSIb3DQEBCDANBglghkgBZQMEAgMF\r\nAKIDAgFAMGQxMDAuBgNVBAMMJ3Byb2NpbG9uIEdST1VQIEN1c3RvbWVyIENBIC0g\r\nRURJRkFDVCAwMzEPMA0GA1UECwwGU3ViIENBMRIwEAYDVQQKDAlTUEktQ0xPVUQx\r\nCzAJBgNVBAYTAkRFMB4XDTIyMDQxNDE0MzI0NloXDTI1MDQxMzE0MzI0NVowgYwx\r\nLDAqBgkqhkiG9w0BCQEWHWJlc192ZXJ0cmllYkBiaWdnZS1lbmVyZ2llLmRlMRUw\r\nEwYDVQQDDAxiZXNfdmVydHJpZWIxJDAiBgNVBAoMG0JJR0dFIEVuZXJnaWUgR21i\r\nSCAmIENvLiBLRzESMBAGA1UEBwwJQXR0ZW5kb3JuMQswCQYDVQQGEwJERTCCAiIw\r\nDQYJKoZIhvcNAQEBBQADggIPADCCAgoCggIBAMUKUWcLYFdBYasnmEtrw31AHmHS\r\nYXY16qt\/w6PmDk26aa1D4lv3UZG0IwFyNKEtJnRt4zd9FqXRM0xJug6FHSzJaPTH\r\nA1WhWwMgXfdm4HmyP87Pm7W4ythxbXsELUZnvVg2WJObU1E0TAD7fDwM+jT2zlp8\r\nhf3gBgT5q9yjEi\/Gn34LqS\/\/BsdULLxolRJOd410sdg9moQ4uwubKMlFFgOVkHyz\r\nTsE2XbAyJda7TFY9JofJsKS9uCwaKebYJRQaarGytEbgVpN9rshiDM6NdTUoffg5\r\ne+I5futkT2zWOc7F45UgpD3+kvvoMOeZOAMhMHpiekTU6w3AQBEI8925wtD0B4Nm\r\ne+DkQqZSBPO5MuYr\/ifqgXSnNEcha0262LfNzmC94ZDXdwoa5le8FS\/ob6plQGl4\r\nYQwlYKsR6EArX5f9k7jnVMB\/2LXp\/DY4HElsRZJak3awgFRoG7qBmpugiBzsghWb\r\nBMHSNlarqQJ78n9WBx1x350ddji\/bEAT5mMkZMuzfyQxcOxNIkQSezmP1DPQ3Q4K\r\nNFK2aQ1um1V3bXAPLzYK0PcuKP1upGG5gWAawtwcgBP7DLZfToTo8+WvtM6wofOk\r\n5QQm9rvb0zF2yKHmR81M2NJQZOyrHjzo7g8T2yT+ExquzPuy+1kKWx5DEd\/7yJJs\r\nemCE\/PeGuXe1x00xAgMBAAGjggFhMIIBXTAMBgNVHRMBAf8EAjAAMB8GA1UdIwQY\r\nMBaAFERE75jnFOhN1pLIH\/nzZ9bk+BmpMGkGCCsGAQUFBwEBBF0wWzAqBggrBgEF\r\nBQcwAoYeaHR0cHM6Ly9wa2kucHJvdGVjdHIuZGUvaXNzdWVyMC0GCCsGAQUFBzAB\r\nhiFodHRwOi8vb2NzcC5zcGktY2xvdWQuY29tL3N0YXR1cy8wKAYDVR0RBCEwH4Ed\r\nYmVzX3ZlcnRyaWViQGJpZ2dlLWVuZXJnaWUuZGUwEwYDVR0lBAwwCgYIKwYBBQUH\r\nAwQwUwYDVR0fBEwwSjBIoEagRIZCaHR0cDovL3BraS5zcGktY2xvdWQuY29tL2Ny\r\nbC9wcm9jaWxvbl9HUk9VUF9DdXN0b21lcl9DQV9FRElGQUNUXzAzMB0GA1UdDgQW\r\nBBReLTw33bjrn89CGniYvQvh\/b7YezAOBgNVHQ8BAf8EBAMCBLAwQQYJKoZIhvcN\r\nAQEKMDSgDzANBglghkgBZQMEAgMFAKEcMBoGCSqGSIb3DQEBCDANBglghkgBZQME\r\nAgMFAKIDAgFAA4ICAQBOJFv8Ocxuu2D9J+C\/sa4gA45ZE1UsfWRX1g6qQkkTxAhQ\r\nlZZbVAf0mT\/pkArYWG5LaUIJqksuyPwWT7d40GuVmUmTWM3bD98dtQ71NpMENhga\r\nK\/WTVSBFIm0VVam2DnbSJJ40IYXooQ9Sj6KtHtSG6XmTap1Wo6+hLDphcJd65NI0\r\n9KaM0kOpQBaS0uKTe2d83FvFVKBzIRJd+ue0cDlUSlm7pwbUEkHaQM3MTAJB6tgG\r\nRFw8GXCjyvxBrgghp9DZJ0vkT68udZNpSYE1L4bLWkpEUVQYbogRgRimi6NLXcP7\r\nIA2xWFV5O7iOZ++JSQr1eOAEZY1qVEv20HRbHLjlmVKUC3XgPlCSFmejH3JOjTg2\r\n4XZmXedRXiWsXLGRicu7bsE47IZm83f0JyNZBj+4VMMKuX14t+5PgySjMm7wByKF\r\n+VrTYuDxNlMOH5piVVfcKYOjpoGIIz0RGxmLlUS6oryLLoq8dO7xg\/zcZMtzq\/JN\r\nWDkVC3D8ldIzHOGhdiIvwgPfL0s\/DCMLulU79237Z7uAbckE8Xdy2YPn7if2tDHx\r\ncAZlFlhVwQlerdu9V\/+HUcxxAIqyYq1dcbH2FTo0pbEbfi0kWSAvnX9nhTs0WBVK\r\nTQx6raD5Z2oxm\/1b7FTFcFoCu5W8bKRlqPFStTnvdIpdBldcUQElWphePG6MfQ==\r\n-----END CERTIFICATE-----\r\n","isActive":true}',
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
