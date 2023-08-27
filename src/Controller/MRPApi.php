<?php

namespace App\Controller;

use App\Repository\MRPRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class MRPApi extends AbstractController
{
    #[Route('/api/mrp/{roverName}/{offset}', name: 'api_mrp_rover_and_offset', methods: ['POST'])]
    public function getMRPByRoverName(
        string        $roverName,
        int           $offset,
        MRPRepository $MRPRepository,
    ): JsonResponse
    {
        $MRPData = $MRPRepository->findByRoverName($roverName, $offset);
        return $this->json($MRPData);
    }

    #[Route('/api/mrp/{dateFrom}/{dateTo}/{offset}', name: 'api_mrp_date_range', methods: ['POST'])]
    public function getMRPByDates(
        string        $dateFrom,
        string        $dateTo,
        int           $offset,
        MRPRepository $MRPRepository,
    ): JsonResponse
    {
        $MRPData = $MRPRepository->findByDateRange($dateFrom, $dateTo, $offset);
        return $this->json($MRPData);
    }

    #[Route('/api/mrp-sol/{roverName}/{sol}', name: 'api_mrp_rover_and_sol', methods: ['POST'])]
    public function getMRPByRoverNameAndSol(
        string        $roverName,
        int           $sol,
        MRPRepository $MRPRepository,
    ): JsonResponse
    {
        $MRPData = $MRPRepository->findByRoverNameAndSol($roverName, $sol);
        return $this->json($MRPData);
    }
}