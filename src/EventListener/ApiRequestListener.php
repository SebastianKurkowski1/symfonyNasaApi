<?php

namespace App\EventListener;

use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\RateLimiter\RateLimiterFactory;

class ApiRequestListener
{
    public function __construct(
        private readonly RateLimiterFactory $authenticatedApiLimiter,
        private readonly Security $security,
    )
    {
    }

    public function __invoke(ResponseEvent $event): void
    {
        $request = $event->getRequest();
        $fireWallName = $this->security->getFirewallConfig($request)->getName();
        $user = $this->security->getUser();
        if ($user === null) return;
        if ($fireWallName !== 'api') return;

        $limiter = $this->authenticatedApiLimiter->create($user->getUserIdentifier());

        $limit = $limiter->consume(0);

        $headers = [
            'X-RateLimit-Remaining' => $limit->getRemainingTokens(),
            'X-RateLimit-Retry-After' => $limit->getRetryAfter()->getTimestamp(),
            'X-RateLimit-Limit' => $limit->getLimit(),
        ];

        $event->getResponse()->headers->add($headers);
    }

}