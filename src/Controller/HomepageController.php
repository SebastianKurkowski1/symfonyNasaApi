<?php

namespace App\Controller;

use App\Service\Login;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomepageController extends AbstractController
{
    #[Route('/', name: 'app_homepage_homepage')]
    public function homepage(Request $request, Login $login): Response
    {
        if ($login->checkIfLoggedIn($request)) {
            return $this->render('homepage/homepage.html.twig');
        } else {
            return $this->forward('App\Controller\LoginController::login', [
                'request'  => $request,
            ]);
        }

    }
}