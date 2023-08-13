<?php

namespace App\Controller;

use App\Repository\APODRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomepageController extends AbstractController
{
    #[Route('/', name: 'app_homepage')]
    public function homepage(Request $request, APODRepository $APODRepository): Response
    {
        dd($APODRepository->findAll());
        return $this->render('homepage/homepage.html.twig');
    }
}