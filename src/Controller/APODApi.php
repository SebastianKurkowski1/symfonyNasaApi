<?php

namespace App\Controller;

use App\Entity\APOD;
use App\Repository\APODRepository;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use OpenApi\Attributes as OA;
use Symfony\Component\Routing\Annotation\Route;

class APODApi extends AbstractController
{
    #[OA\Tag('APOD')]
    #[OA\Response(
        response: 200,
        description: 'Returns astronomical picture of the day',
        content: new Model(type: APOD::class),
    )]
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