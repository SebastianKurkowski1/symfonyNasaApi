<?php

namespace App\Controller;

use App\Repository\MRPRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class MRPApi extends AbstractController
{
    #[Route('/api/mrp/{roverName}/{offset}', name: 'api_mrp', methods: ['POST'])]
    public function getMRP(
        string        $roverName,
        int           $offset,
        MRPRepository $MRPRepository,
    ): JsonResponse
    {
        $MRPData = $MRPRepository->findByRoverName($roverName, $offset);
        return $this->json($MRPData);
    }
}