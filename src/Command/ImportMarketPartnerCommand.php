<?php

declare(strict_types=1);

namespace App\Command;

use App\Common\FileReader;
use App\Service\Import\ImportMarketPartnerService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

#[AsCommand(
    name: 'market-partner:import',
    description: 'Import market partners.'
)]
class ImportMarketPartnerCommand extends Command
{
    const MARKET_PARTNER_DATA_FILE_NAME = "market_partner_for_certificates_postman.csv";

    public function __construct(
        private ImportMarketPartnerService $importMarketPartnerService,
        private ParameterBagInterface $parameterBag,
        private EntityManagerInterface $entityManager,
        private FileReader $fileReader
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $marketPartners = $this->fileReader->csvToArray(
            $this->parameterBag->get('importCertificateDirectory') . '/' . self::MARKET_PARTNER_DATA_FILE_NAME
        );

        foreach ($marketPartners as $marketPartner) {
            $this->importMarketPartnerService->import($marketPartner);
            $this->entityManager->flush();
            $this->entityManager->clear();
        }

        return Command::SUCCESS;
    }
}
