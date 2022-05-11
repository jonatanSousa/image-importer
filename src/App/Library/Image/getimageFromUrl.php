<?php

namespace Console\App\Library\Image;
use Psr\Log\LoggerInterface;

class getimageFromUrl {
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }
}