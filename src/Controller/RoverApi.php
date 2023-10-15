<?php

namespace App\Controller;

use App\Entity\MRP;
use App\Repository\RoverRepository;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Attributes as OA;

class RoverApi extends AbstractController
{
    #[OA\Tag('Rover')]
    #[OA\Response(
        response: 200,
        description: "Returns max sol of specified rover <br><br>
         Available rovers: <br>
        - Curiosity <br>
        - Opportunity <br>
        - Spirit <br>
        - Perseverance",
        content: new Model(type: MRP::class)
    )]
    #[Route('/api/mrp-sol/{roverName}', name: 'api_mrp_rover_max_sol', methods: ['POST'])]
    public function getMaxSolOfRover(
        string        $roverName,
        RoverRepository $roverRepository,
    ): JsonResponse
    {
        $MRPData = $roverRepository->getMaxSolByName($roverName);
        return $this->json($MRPData);
    }
}