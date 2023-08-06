<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RegisterController extends AbstractController
{
    #[Route('/register', name: 'app_register_register')]
    public function register(): Response
    {
        return $this->render('register/register.html.twig');
    }

    #[Route('/register/submit', name: 'app_register_submit', methods: ['POST'])]
    public function submit(Request $request): Response
    {
       $form = $this->createForm();
    }
}