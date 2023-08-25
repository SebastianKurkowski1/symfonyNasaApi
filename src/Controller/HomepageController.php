<?php

namespace App\Controller;

use App\Repository\APODRepository;
use App\Repository\MRPRepository;
use App\Repository\RoverRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class HomepageController extends AbstractController
{
    #[Route('/', name: 'app_homepage')]
    public function homepage(Request $request, RoverRepository $roverRepository, HttpClientInterface $httpClient, EntityManagerInterface $entityManager): Response
    {
        return $this->render('homepage/homepage.html.twig');
    }
}