<?php

namespace App\Security;

use Lexik\Bundle\JWTAuthenticationBundle\Security\Authenticator\JWTAuthenticator;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\TokenExtractor\TokenExtractorInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\RateLimiter\RateLimiterFactory;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;
use Symfony\Contracts\Service\Attribute\Required;
use Symfony\Contracts\Translation\TranslatorInterface;

class CustomJWTAuthenticator extends JWTAuthenticator
{
    private readonly Security $security;
    private readonly RateLimiterFactory $rateLimiter;
    public function __construct(
        JWTTokenManagerInterface $jwtManager,
        EventDispatcherInterface $eventDispatcher,
        TokenExtractorInterface  $tokenExtractor,
        UserProviderInterface    $userProvider,
        TranslatorInterface      $translator = null,
    )
    {
        parent::__construct($jwtManager, $eventDispatcher, $tokenExtractor, $userProvider, $translator);
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        $limiter = $this->rateLimiter->create($this->security->getUser()->getUserIdentifier());

        $limit = $limiter->consume();

        $headers = [
            'X-RateLimit-Remaining' => $limit->getRemainingTokens(),
            'X-RateLimit-Retry-After' => $limit->getRetryAfter()->getTimestamp(),
            'X-RateLimit-Limit' => $limit->getLimit(),
        ];

        if (false === $limit->isAccepted()) {
            return new Response('API request limit exhausted', Response::HTTP_TOO_MANY_REQUESTS, $headers);
        }

        return parent::onAuthenticationSuccess($request, $token, $firewallName);
    }

    #[Required]
    public function setSecurity(Security $security)
    {
        $this->security = $security;
    }

    #[Required]
    public function setRateLimiter(RateLimiterFactory $authenticatedApiLimiter)
    {
        $this->rateLimiter = $authenticatedApiLimiter;
    }

}