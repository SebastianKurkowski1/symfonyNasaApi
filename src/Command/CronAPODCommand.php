<?php

namespace App\Command;


use App\Repository\APODRepository;
use App\Service\Cron\APOD;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Serializer\SerializerInterface;

#[AsCommand('app:cron:apod', 'Fetches astronomical picture of the day')]
class CronAPODCommand extends Command
{
    public function __construct(
        private readonly APOD                   $APOD,
        private readonly APODRepository         $APODRepository,
        private readonly SerializerInterface    $serializer,
        private readonly EntityManagerInterface $entityManager,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addOption('date', '-d', InputOption::VALUE_REQUIRED, 'Date to fetch APOD from formay YYYY-mm-dd')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $optionValue = $input->getOption('date');

        if ($optionValue) {
            $date = $optionValue;
        } else {
            $date = new \DateTime();
            $date = $date->format('Y-m-d');
        }

        $data = $this->APOD->getData($date);

        if ($data) {
            $APODEntity = $this->serializer->deserialize($data, \App\Entity\APOD::class, 'json');
            $duplicates = $this->APODRepository->findOneBy(['date' => $APODEntity->getDate()]);

            if ($duplicates) {
                $io->success(sprintf('Date "%s" has been already fetched', $date));
                return Command::SUCCESS;
            }

            $this->entityManager->persist($APODEntity);
            $this->entityManager->flush();

            $io->success(sprintf('Successful fetch of APOD from "%s"', $date));
            return Command::SUCCESS;
        }

        $io->error('Something went wrong');
        return Command::FAILURE;
    }
}