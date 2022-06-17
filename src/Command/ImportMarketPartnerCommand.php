<?php

declare(strict_types=1);

namespace App\Command;

use App\Common\FileReader;
use App\Exception\File\FileReadException;
use App\Service\Import\ImportMarketPartnerService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\HttpKernel\KernelInterface;

#[AsCommand(
    name: 'market-partner:import',
    description: 'Import market partners.'
)]
class ImportMarketPartnerCommand extends Command
{
    public const MARKET_PARTNER_DATA_FILE_NAME = "market_partner.csv";
    public const COUNT_MARKET_PARTNER = 50;

    public function __construct(
        private ImportMarketPartnerService $importMarketPartnerService,
        private EntityManagerInterface $entityManager,
        private KernelInterface $appKernel,
        private FileReader $fileReader
    ) {
        parent::__construct();
    }

    /**
     * @throws FileReadException
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $micrometerStart = microtime(true);

        $importPath = $this->appKernel->getProjectDir() . $_ENV['CERTIFICATES_IMPORT_DIRECTORY'];

        $marketPartners = $this->fileReader->csvToArray(
            $importPath . static::MARKET_PARTNER_DATA_FILE_NAME
        );

        $numberMarketPartner = 0;
        foreach ($marketPartners as $marketPartner) {
            $output->writeln([
                'Import: ' . $marketPartner['partnerId']
            ]);

            $this->importMarketPartnerService->import($marketPartner, $importPath);

            if ($numberMarketPartner % self::COUNT_MARKET_PARTNER === 0) {
                $this->entityManager->flush();
            }

            $numberMarketPartner++;
        }
        $this->entityManager->flush();

        $output->writeln([
            (int)(microtime(true) - $micrometerStart),
        ]);

        return Command::SUCCESS;
    }
}
