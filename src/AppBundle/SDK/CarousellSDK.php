<?php

namespace AppBundle\SDK;

use Psr\Log\LoggerInterface;
use GuzzleHttp\ClientInterface;

class CarousellSDK
{
    const COUNTRY_SG = '1880251';

    /** @var LoggerInterface */
    private $logger;

    /** @var ClientInterface */
    private $client;

    private $defaultOpts = [
        'country_id' => self::COUNTRY_SG,
        'sort' => 'recent',
        'count' => 40,
    ];

    public function __construct(ClientInterface $client, LoggerInterface $logger)
    {
        $this->logger = $logger;
        $this->client = $client;
    }

    public function products($options)
    {
        $options = array_merge($this->defaultOpts, $options);

        $response = $this->client->request('GET', 'products/', ['query' => $options]);

        if($response->getStatusCode() >= 200 && $response->getStatusCode() < 300)
        {
            return \GuzzleHttp\json_decode($response->getBody(), true);
        }
        else {
            return [];
        }
    }
}