<?php

namespace AppBundle\Scrappers;

use Psr\Log\LoggerInterface;

class Carousell
{
    /** @var LoggerInterface */
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }
}