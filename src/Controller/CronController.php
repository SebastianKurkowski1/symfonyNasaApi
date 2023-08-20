<?php

namespace App\Controller;

use App\Repository\APODRepository;
use App\Repository\CameraRepository;
use App\Repository\MRPRepository;
use App\Repository\RoverRepository;
use App\Service\Cron\APOD;
use App\Service\Cron\MRP;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class CronController extends AbstractController
{
    #[Route('/cron/apod', name: 'app_cron_apod')]
    public function fetchAPOD(
        APOD                   $APOD,
        APODRepository         $APODRepository,
        SerializerInterface    $serializer,
        EntityManagerInterface $entityManager,
    ): Response
    {
        $data = $APOD->getData();

        if ($data) {
            $APODEntity = $serializer->deserialize($data, \App\Entity\APOD::class, 'json');
            $duplicates = $APODRepository->findOneBy(['date' => $APODEntity->getDate()]);

            if ($duplicates) return new Response('Duplicate');

            $entityManager->persist($APODEntity);
            $entityManager->flush();
            return new Response('success');
        }

        return new Response('failure');
    }

    #[Route('/cron/mrp', name: 'app_cron_mrp')]
    public function fetchMRP(
        MRP                 $MRP,
        MRPRepository       $MRPRepository,
        SerializerInterface $serializer,
        EntityManagerInterface $entityManager,
        RoverRepository $roverRepository,
    ): Response
    {
        $data = $MRP->getData();

        if ($data) {
            $data = json_decode($data, false);

            foreach ($data->photos as $photoData) {
                $MRPEntity = $serializer->deserialize(json_encode($photoData), \App\Entity\MRP::class, 'json');
                $MRPEntity->setId($photoData->id);
                $MRPEntity->setCameraId($photoData->camera->id);

                $duplicates = $MRPRepository->find($photoData->id);

                if ($duplicates) return new Response('Duplicate');

                $entityManager->persist($MRPEntity);

                $roverEntity = $roverRepository->find($photoData->rover->id);

                if ($roverEntity) {
                    $roverEntity->setStatus($photoData->rover->status);
                    $roverEntity->setMaxSol($photoData->rover->max_sol);
                    $roverEntity->setMaxDate($photoData->rover->max_date);
                    $roverEntity->setTotalPhotos($photoData->rover->total_photos);
                    $entityManager->persist($roverEntity);
                } else {
                    $roverEntity = $serializer->deserialize(json_encode($photoData->rover), \App\Entity\Rover::class, 'json');
                }

                $roverEntity->setId($photoData->rover->id);

                $entityManager->persist($roverEntity);
                $entityManager->flush();
                return new Response('success');
            }
        }

        return new Response('No data fetched');
    }
}