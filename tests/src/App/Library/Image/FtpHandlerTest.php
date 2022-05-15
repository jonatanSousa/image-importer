<?php

namespace src\App\Library\Image;

use Console\App\Library\Image\FtpHandler;
use PHPUnit\Framework\TestCase;

class FtpHandlerTest extends TestCase
{
    public function testUploadFTP() {

        $_ENV['FTP_HOST'] = "ftp.test.com";
        $_ENV['FTP_USERNAME'] = "test";
        $_ENV['FTP_PASSWORD'] = "testKey";

        $ftpHandler = new FtpHandler();

        $this->assertTrue(
            method_exists($ftpHandler, 'uploadFTP'),
            'Class does not have method myFunction'
        );
    }
}