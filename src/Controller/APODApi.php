<?php

namespace App\Controller;

use App\Repository\APODRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class APODApi extends AbstractController
{
    #[Route('/api/apod/{date}', name: 'api_apod', methods: ['POST'])]
    public function getMRP(
        string        $date,
        APODRepository $APODRepository,
    ): JsonResponse
    {
        $MRPData = $APODRepository->findOneBy(['date' => $date]);
        return $this->json($MRPData);
    }
}