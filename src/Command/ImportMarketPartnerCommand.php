<?php

declare(strict_types=1);

namespace App\Command;

use App\Service\Import\ImportMarketPartnerService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'market-partner:import',
    description: 'Import market partners.'
)]
class ImportMarketPartnerCommand extends Command
{
    public function __construct(private ImportMarketPartnerService $importMarketPartnerService)
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->importMarketPartnerService->importFromCsv();
        return Command::SUCCESS;
    }
}
