<?php

namespace App\Security;

use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationCredentialsNotFoundException;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAccountStatusException;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;
use Symfony\Component\Security\Http\Authenticator\AbstractLoginFormAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;

class LoginAuthenticator extends AbstractLoginFormAuthenticator
{
    public const LOGIN_ROUTE = '/login';

    public function __construct(
        private readonly UserRepository $user,
    )
    {

    }

    protected function getLoginUrl(Request $request): string
    {
        return self::LOGIN_ROUTE;
    }

    public function authenticate(Request $request): Passport
    {
        $email = $request->request->get('_email');
        $password = $request->request->get('_password');


        return new Passport(
            new UserBadge($email, function ($userIdentifier) {
                $user = $this->user->findOneBy(['email' => $userIdentifier]);

                if (!$user) {
                    throw new AuthenticationCredentialsNotFoundException('Nie ma użytkownika o takim loginie i haśle');
                }

                if (!$user->isVerified()) {
                    throw new CustomUserMessageAccountStatusException('Zweryfikuj swój email przed zalogowaniem');
                }

                return $user;
            }),
            new PasswordCredentials($password)
        );
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        return new RedirectResponse('/login');
    }
}