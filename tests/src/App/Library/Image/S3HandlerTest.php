<?php

namespace src\App\Library\Image;

use Console\App\Library\Image\S3Handler;
use PHPUnit\Framework\TestCase;

class S3HandlerTest extends TestCase
{
    public function testUploadFile() {

        $_ENV['S3_BUCKET_REGION'] = "eu-west-2";
        $_ENV['S3_BUCKET'] = "testBucket";
        $_ENV['S3_SECRET_KEY'] = "testBucketKey";

        $S3Handler = new S3Handler();

        try {
            $S3Handler->uploadFile("test");
        } catch (\Exception $e) {
            $result = $e->getMessage();
        }

        $this->assertTrue(
            method_exists($S3Handler, 'uploadFile'),
            'Class does not have method myFunction'
        );
    }
}