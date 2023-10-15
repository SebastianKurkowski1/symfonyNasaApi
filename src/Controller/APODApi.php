<?php

namespace App\Controller;

use App\Entity\APOD;
use App\Repository\APODRepository;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class APODApi extends AbstractController
{
    #[OA\Tag('APOD')]
    #[OA\Response(
        response: 200,
        description: 'Returns astronomical picture of the day',
        content: new Model(type: APOD::class),
    )]
    #[Route('/api/apod/{date}', name: 'api_apod', methods: ['POST'])]
    public function getAPOD(
        string         $date,
        APODRepository $APODRepository,
    ): JsonResponse
    {
        $MRPData = $APODRepository->findOneBy(['date' => $date]);
        return $this->json($MRPData);
    }

    #[OA\Tag('APOD')]
    #[OA\Response(
        response: 200,
        description: 'Returns available range of astronomy pictures of the day',
    )]
    #[Route('/api/apod-range', name: 'api_range', methods: ['POST'])]
    public function getAPODRange(
        APODRepository $APODRepository,
    ): JsonResponse
    {
        $firstAPOD = $APODRepository->findOneBy([], ['date' => 'ASC']);
        $lastAPOD = $APODRepository->findOneBy([], ['date' => 'DESC']);
        return $this->json(['first' => $firstAPOD->getDate(), 'last' =>$lastAPOD->getDate()]);
    }
}