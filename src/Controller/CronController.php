<?php

namespace App\Controller;

use App\Repository\APODRepository;
use App\Service\Cron\APOD;
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
            $apodEntity = $serializer->deserialize($data, \App\Entity\APOD::class, 'json');
            $duplicates = $APODRepository->findOneBy(['date' => $apodEntity->getDate()]);

            if ($duplicates) return new Response('Duplicate');

            $entityManager->persist($apodEntity);
            return new Response('success');
        }

        return new Response('failure');
    }
}