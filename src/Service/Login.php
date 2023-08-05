<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\Request;

class Login
{
    public function __construct()
    {
    }

    public function checkIfLoggedIn(Request $request): bool
    {
        $session = $request->getSession();
        return $session->get('loggedIn') === true;
    }
}