<?php

namespace src\App\Library\Image\FileSystem;

use Console\App\Library\Image\FileSystem\Image;
use PHPUnit\Framework\TestCase;

class ImageTest extends TestCase
{

    /**
     * @return void
     * @throws \Exception
     */
    public function testSaveImage() {
        $imageClass = new Image();

        $result = $imageClass->save("https://symfony.com/images/logos/header-logo.svg");

        $this->assertEquals($result, 4609);
        $this->assertTrue(
            method_exists($imageClass, 'save'),
            'Class does not have method myFunction'
        );
    }

    public function testSaveNotImageFile() {
        $imageClass = new Image();

        try{
            $imageClass->save("https://symfony.com/images/logos/header-logo.exe");
        } catch (\Exception $e ) {
            $result = $e->getMessage();
        }

        $this->assertEquals($result,'Only Images are allowed' );

        $this->assertTrue(
            method_exists($imageClass, 'save'),
            'Class does not have method myFunction'
        );

    }

    public function testGetImageList() {
        $imageClass = new Image();

        $result = $imageClass->getImageList();

        $this->assertNotEmpty($result);
        $this->assertTrue(
            method_exists($imageClass, 'getImageList'),
            'Class does not have method myFunction'
        );
    }

    public function testDeleteImage() {
        $imageClass = new Image();

        $result = $imageClass->delete("header-logo.svg");

        $this->assertNotEmpty($result);
        $this->assertTrue(
            method_exists($imageClass, 'save'),
            'Class does not have method myFunction'
        );
    }
}