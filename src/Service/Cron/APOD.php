<?php

namespace App\Service\Cron;

use Psr\Log\LoggerInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class APOD
{
    public function __construct(
        private readonly HttpClientInterface $client,
        private readonly LoggerInterface $logger,
    )
    {
    }

    public function getData(string|null $date = null): string|false
    {
        if (!$date) {
            $date = new \DateTime();
            $date = $date->format('Y-m-d');
        }

        try {
            $response = $this->client->request(
                'GET',
                "https://api.nasa.gov/planetary/apod?api_key={$_ENV['NASA_API_KEY']}&date=$date",
            );
            return $response->getContent();
        } catch (TransportExceptionInterface|ClientExceptionInterface|RedirectionExceptionInterface|ServerExceptionInterface $e) {
            $this->logger->error($e->getMessage());
        }

        return false;
    }

}
