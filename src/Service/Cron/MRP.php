<?php

namespace App\Service\Cron;

use Psr\Log\LoggerInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class MRP
{
    public function __construct(
        private readonly HttpClientInterface $client,
        private readonly LoggerInterface $logger,
    )
    {
    }

    public function getData(): string|false
    {
        $actualDate = new \DateTime();
        $actualDate = $actualDate->format('Y-m-d');

        try {
            $response = $this->client->request(
                'GET',
                "https://api.nasa.gov/mars-photos/api/v1/rovers/curiosity/photos?earth_date=$actualDate&api_key={$_ENV['NASA_API_KEY']}",
            );
            return $response->getContent();
        } catch (TransportExceptionInterface|ClientExceptionInterface|RedirectionExceptionInterface|ServerExceptionInterface $e) {
            $this->logger->error($e->getMessage());
        }

        return false;
    }
}