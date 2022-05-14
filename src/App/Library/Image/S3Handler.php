<?php

namespace Console\App\Library\Image;
use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;


class S3Handler
{
    private $s3;

    public function __construct()
    {
        $this->s3 = new S3Client([
            'version' => 'latest',
            'region'  => $_ENV['S3_BUCKET_REGION']
        ]);
    }

    /**
     * @param $file
     * @return \Aws\Result
     * @throws \Exception
     */
    public function uploadFile($file){
        try {
            return $this->s3->putObject([
                'Bucket' => $_ENV['S3_BUCKET'],
                'Key'    => $_ENV['S3_SECRET_KEY'],
                'Body'   => fopen('images/'.$file, 'r'),
                'ACL'    => 'public-read',
            ]);
        } catch (S3Exception $e) {
            throw new \Exception('Image does Not Exists use GET action to list images'.$e->getMessage());
        }
    }
}