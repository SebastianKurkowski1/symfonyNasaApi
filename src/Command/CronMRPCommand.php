<?php

namespace App\Command;


use App\Service\Cron\MRP;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand('app:cron:mrp', 'Fetches pictures from martian rovers')]
class CronMRPCommand extends Command
{
    public function __construct(
        private readonly MRP $MRP,
    )
    {
        parent::__construct();
    }

    protected function configure(): void
    {

    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $data = $this->MRP->fetchDataForAllRovers();

        if (!empty($data)) {
            foreach ($data as $info) {
                $io->success($info);
            }
            return Command::SUCCESS;
        } else {
            $io->error('Something went wrong. No data was fetched');
            return Command::FAILURE;
        }
    }
}