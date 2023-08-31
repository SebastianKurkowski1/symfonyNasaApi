<?php

namespace App\Service\Cron;

use App\Entity\Rover;
use App\Repository\MRPRepository;
use App\Repository\RoverRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class MRP
{
    public function __construct(
        private readonly HttpClientInterface    $client,
        private readonly LoggerInterface        $logger,
        private readonly MRPRepository          $MRPRepository,
        private readonly SerializerInterface    $serializer,
        private readonly EntityManagerInterface $entityManager,
        private readonly RoverRepository        $roverRepository,
    )
    {
    }

    public function fetchDataForAllRovers(): array
    {
        $logData = [];

        foreach (Rover::ROVERS as $rover) {
            $lastSol = $this->MRPRepository->getLastSol($rover);
            if (!$lastSol) $lastSol = 1;
            else $lastSol = $lastSol[0]['sol'];

            $data = self::getDataBySol($rover, $lastSol + 1);
            if ($data) {
                $data = json_decode($data, false);
                foreach ($data->photos as $photoData) {
                    $MRPEntity = $this->serializer->deserialize(json_encode($photoData), \App\Entity\MRP::class, 'json');
                    $MRPEntity->setId($photoData->id);
                    $MRPEntity->setCameraId($photoData->camera->id);
                    $MRPEntity->setRoverId($photoData->rover->id);

                    $duplicates = $this->MRPRepository->find($photoData->id);

                    if ($duplicates) {
                        $logData[] = ["Duplicate value $rover"];
                        continue;
                    }

                    $this->entityManager->persist($MRPEntity);

                    $roverEntity = $this->roverRepository->find($photoData->rover->id);

                    if ($roverEntity) {
                        $roverEntity->setStatus($photoData->rover->status);
                        $roverEntity->setMaxSol($photoData->rover->max_sol);
                        $roverEntity->setMaxDate(new DateTime($photoData->rover->max_date));
                        $roverEntity->setTotalPhotos($photoData->rover->total_photos);
                        $this->entityManager->persist($roverEntity);
                    } else {
                        $roverEntity = $this->serializer->deserialize(json_encode($photoData->rover), Rover::class, 'json');
                    }

                    $roverEntity->setId($photoData->rover->id);

                    $this->entityManager->persist($roverEntity);
                }
                $this->entityManager->flush();
                $logData[] = "Successfully fetched $rover sol " . ($lastSol + 1);
            }

        }
        return $logData;
    }

    public function getDataBySol(string $roverName, int $sol): string|false
    {
        try {
            $response = $this->client->request(
                'GET',
                "https://api.nasa.gov/mars-photos/api/v1/rovers/$roverName/photos?sol=$sol&api_key={$_ENV['NASA_API_KEY']}",
            );
            return $response->getContent();
        } catch (TransportExceptionInterface|ClientExceptionInterface|RedirectionExceptionInterface|ServerExceptionInterface $e) {
            $this->logger->error($e->getMessage());
        }

        return false;
    }
}