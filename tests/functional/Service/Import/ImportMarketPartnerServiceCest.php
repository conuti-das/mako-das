<?php

declare(strict_types=1);

namespace App\Tests\functional\Service\Import;

use App\Common\FileReader;
use App\Entity\MarketPartnerEmail;
use App\Exception\File\FileReadException;
use App\Service\Import\ImportMarketPartnerService;
use App\Tests\FunctionalTester;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\KernelInterface;

class ImportMarketPartnerServiceCest
{
    private EntityManagerInterface $entityManager;
    private ImportMarketPartnerService $importMarketPartnerService;
    private KernelInterface $appKernel;
    private FileReader $fileReader;

    public const MARKET_PARTNER_DATA_FILE_NAME_TEST = "market_partner.csv";


    public function _before(FunctionalTester $I): void
    {
        $this->entityManager = $I->grabService(EntityManagerInterface::class);
        $this->importMarketPartnerService = $I->grabService(ImportMarketPartnerService::class);
        $this->appKernel = $I->grabService(KernelInterface::class);
        $this->fileReader = $I->grabService(FileReader::class);
    }

    /**
     * @throws Exception
     */
    public function _after(FunctionalTester $I): void
    {
        $connection = $this->entityManager->getConnection();
        $platform = $connection->getDatabasePlatform();
        $connection->executeQuery('SET FOREIGN_KEY_CHECKS = 0;');
        $connection->executeStatement($platform->getTruncateTableSQL('market_partner_email', true));
        $connection->executeStatement($platform->getTruncateTableSQL('market_partner', true));
        $connection->executeStatement($platform->getTruncateTableSQL('market_partner_email_import_log', true));
        $connection->executeStatement($platform->getTruncateTableSQL('market_partner_import_log', true));
        $connection->executeQuery('SET FOREIGN_KEY_CHECKS = 1;');
    }

    /**
     * @throws FileReadException
     */
    public function testMarketPartnerImport(FunctionalTester $I): void
    {
        $importPath = $this->appKernel->getProjectDir() . $_ENV['CERTIFICATES_IMPORT_DIRECTORY'];

        $marketPartners = $this->fileReader->csvToArray(
            $importPath .
            self::MARKET_PARTNER_DATA_FILE_NAME_TEST
        );

        foreach ($marketPartners as $marketPartner) {
            $this->importMarketPartnerService->import($marketPartner, $importPath);
        }

        $this->entityManager->flush();

        // need to commit, because we use different transaction for the import
        $this->entityManager->commit();

        $I->seeInDatabase(
            'market_partner',
            [
                'active' => '1',
                'deleted' => '0',
                'type' => 'provider',
                'energy' => 'electricity',
                'partner_id_type' => null,
                'partner_id_gmsb' => null,
                'organization' => 'Stadtwerke Eberbach GmbH',
                'zip' => '69412',
                'city' => 'Eberbach',
                'street' => 'Güterbahnhofstr. 	',
                'house_number' => '4',
                'bic' => 'NULL',
                'bank' => 'NULL',
                'phone' => null,
                'register_court' => null,
                'register_number' => null,
                'sign' => '0',
                'compress' => '0',
                'encrypt' => '0',
                'reminder_email_address' => 'netznutzung@sw-eberbach.de	',
                'using_tum_catalog' => '0'
            ]
        );

        $I->seeInDatabase('market_partner_email', [
            'email' => 'strom-vertrieb-eberbach@suedwest-edm.de',
            'type' => MarketPartnerEmail::TYPE_EDIFACT,
            'ssl_certificate' => 'LS0tLS1CRUdJTiBDRVJUSUZJQ0FURS0tLS0tCk1JSUdFekNDQk1lZ0F3SUJBZ0lNSmI5QkxZVXZYOXZGOEk5ZU1FRUdDU3FHU0liM0RRRUJDakEwb0E4d0RRWUoKWUlaSUFXVURCQUlCQlFDaEhEQWFCZ2txaGtpRzl3MEJBUWd3RFFZSllJWklBV1VEQkFJQkJRQ2lBd0lCSURCYgpNUXN3Q1FZRFZRUUdFd0pDUlRFWk1CY0dBMVVFQ2hNUVIyeHZZbUZzVTJsbmJpQnVkaTF6WVRFeE1DOEdBMVVFCkF4TW9SMnh2WW1Gc1UybG5iaUJIUTBNZ1VqTWdVR1Z5YzI5dVlXeFRhV2R1SURJZ1EwRWdNakF5TURBZUZ3MHkKTVRFeU1UWXdOalV3TkRWYUZ3MHlNakV5TVRjd05qVXdORFZhTUlIVk1Rc3dDUVlEVlFRR0V3SkVSVEViTUJrRwpBMVVFQ0JNU1FtRmtaVzR0VjNWbGNuUjBaVzFpWlhKbk1SSXdFQVlEVlFRSEV3bFVkV1ZpYVc1blpXNHhLekFwCkJnTlZCQW9USWxOMVpXUjNaWE4wWkdWMWRITmphR1VnVTNSeWIyMW9ZVzVrWld4eklFZHRZa2d4TURBdUJnTlYKQkFNTUozTjBjbTl0TFhabGNuUnlhV1ZpTFdWaVpYSmlZV05vUUhOMVpXUjNaWE4wTFdWa2JTNWtaVEUyTURRRwpDU3FHU0liM0RRRUpBUlluYzNSeWIyMHRkbVZ5ZEhKcFpXSXRaV0psY21KaFkyaEFjM1ZsWkhkbGMzUXRaV1J0CkxtUmxNSUlCSWpBTkJna3Foa2lHOXcwQkFRRUZBQU9DQVE4QU1JSUJDZ0tDQVFFQTRjT2VvRVVNejg0YmZxbFIKV2RrQlhKMHZhdTJ1a1A2R05xaUhremxtV1J5WW1BZDVqSXRBL2UzNWtyZkpMM3RjdHVwL2ljSlN0SFVwMlp2NAptdExMc0RFOGV2Rmtuclc3eWVhKy9YOHB6QXhqRldJNVpjRFBIeUhTNVVSN0xvaHZWcEdiMVJRQnR0M3VIWURnCm1KT0phQU9veUlXdi84eHZjN0VGSy9xWXU0bVRPNmt5WU9UVmRUM3IyZC9vcHZNY250YytTanVheGlGcFVWUHAKdnhMUGNGR0pYbTV3TEFpaXVFcXhGVU9rdHZqSkx1RmNFNWpoWjVxdU8xMVMvWEsycFMwbk83N25tWEgzMHdVcworcTZ1QUVDYWxGcW5JVjFIdXl1anBQd3dOZ3doanNWUWJnT3lSekJzVzdvTUVaTTdZb2JMdzBXbEVMbWdCeVZKCjJBaXk1d0lEQVFBQm80SUI4akNDQWU0d0RnWURWUjBQQVFIL0JBUURBZ1dnTUlHakJnZ3JCZ0VGQlFjQkFRU0IKbGpDQmt6Qk9CZ2dyQmdFRkJRY3dBb1pDYUhSMGNEb3ZMM05sWTNWeVpTNW5iRzlpWVd4emFXZHVMbU52YlM5agpZV05sY25RdlozTm5ZMk55TTNCbGNuTnZibUZzYzJsbmJqSmpZVEl3TWpBdVkzSjBNRUVHQ0NzR0FRVUZCekFCCmhqVm9kSFJ3T2k4dmIyTnpjQzVuYkc5aVlXeHphV2R1TG1OdmJTOW5jMmRqWTNJemNHVnljMjl1WVd4emFXZHUKTW1OaE1qQXlNREJOQmdOVkhTQUVSakJFTUVJR0Npc0dBUVFCb0RJQktBb3dOREF5QmdnckJnRUZCUWNDQVJZbQphSFIwY0hNNkx5OTNkM2N1WjJ4dlltRnNjMmxuYmk1amIyMHZjbVZ3YjNOcGRHOXllUzh3Q1FZRFZSMFRCQUl3CkFEQkpCZ05WSFI4RVFqQkFNRDZnUEtBNmhqaG9kSFJ3T2k4dlkzSnNMbWRzYjJKaGJITnBaMjR1WTI5dEwyZHoKWjJOamNqTndaWEp6YjI1aGJITnBaMjR5WTJFeU1ESXdMbU55YkRBeUJnTlZIUkVFS3pBcGdTZHpkSEp2YlMxMgpaWEowY21sbFlpMWxZbVZ5WW1GamFFQnpkV1ZrZDJWemRDMWxaRzB1WkdVd0hRWURWUjBsQkJZd0ZBWUlLd1lCCkJRVUhBd0lHQ0NzR0FRVUZCd01FTUI4R0ExVWRJd1FZTUJhQUZKWXowZVpZRjFzMGRZcUJWbVRWdmtqZW9ZL1AKTUIwR0ExVWREZ1FXQkJSR3dYZzJrTTNOejFhWHc1V3M1VmYxdU1CMDBEQkJCZ2txaGtpRzl3MEJBUW93TktBUApNQTBHQ1dDR1NBRmxBd1FDQVFVQW9Sd3dHZ1lKS29aSWh2Y05BUUVJTUEwR0NXQ0dTQUZsQXdRQ0FRVUFvZ01DCkFTQURnZ0VCQUQwdlZvRkxBUlA0L2k2d1Z6VzQ4N3hzOTA1V0VEU1FDY0ZsYkk1bnYyNFJxell4eGZLakZSU04KZGc3enR0bFYvSkVIMm5jQWt4OHVEc3BZdHhpc0FMdWp2MnhDRVI3WWk4SVlhQnFzckhzNGJwT3pYWmNLTkllWAp0YU9NVDFRZmpkb1VkZSs5ZDhDUkcrWlh2VUM5OThrd3RpSEdQWFBNaDUrbFRpVFZlN3c0UmNDYmhrTzNrUENjCm8yTUgxcElXNHVjcXdjZWkrTU0vbG9GK1NYM09WNWNET29TWG9lbkxOMzdZZXdLNDBjcW5OcmI2SUhsbHhpcUcKSWFCZmNsckhuWlJyVHR2RjErZkovenp6Vkp5UVhXNUdWYllWMTR3MjlsdENuVVFMazJEMGVYVEVYOERvbDNvMwpDNEFrRjRUQ0Q5eSs0VjR5dG5QM1JpenM4K0lzQzFzPQotLS0tLUVORCBDRVJUSUZJQ0FURS0tLS0tCg==',
            'ssl_certificate_expiration' => '2022-12-17 06:50:45',
            'active_from' => '2021-12-16 06:50:45',
            'active_until' => '2022-12-17 06:50:45',
        ]);

        $I->seeInDatabase('market_partner_email', ['email' => 'strom-vertrieb-eberbach@suedwest-edm.de']);
        $I->seeNumRecords(3, 'market_partner');
        $I->seeNumRecords(3, 'market_partner_email');
        $I->seeNumRecords(3, 'market_partner_email_import_log');
        $I->seeNumRecords(3, 'market_partner_import_log');
    }
}
