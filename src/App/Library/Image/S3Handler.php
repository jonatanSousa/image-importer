<?php

namespace Console\App\Library\Image;
use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;
use Symfony\Component\Console\Logger\ConsoleLogger;

class S3Handler
{
    private S3Client $s3;
    private ConsoleLogger $logger;

    /**
     * @param S3Client $s3Client
     * @param ConsoleLogger $logger
     */
    public function __construct( S3Client $s3Client, ConsoleLogger $logger )
    {
        $this->s3 = new $s3Client([
            'version' => 'latest',
            'region'  => 'us-west-2'
        ]);

        $this->logger = new $logger();
    }

    /**
     * @param $file
     * @return \Aws\Result|void
     */
    public function uploadFile($file){
        try {
            return $this->s3->putObject([
                'Bucket' => 'my-bucket',
                'Key'    => 'my-object',
                'Body'   => fopen('/path/to/'.$file, 'r'),
                'ACL'    => 'public-read',
            ]);
        } catch (S3Exception $e) {
            $this->logger->log("There was an error uploading the file.", $e->getMessage());
        }
    }
}