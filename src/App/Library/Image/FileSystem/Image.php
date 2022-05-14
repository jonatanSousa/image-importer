<?php

namespace Console\App\Library\Image\FileSystem;

class Image
{
    const get = 'GET';
    const delete = 'DELETE';
    const save = 'SAVE';

    /**
     * @return array
     */
    public function getImageList(): array
    {
        if($result = array_diff(scandir('images/'), array('.', '..'))) {
            return $result;
        }
        return [];
    }

    /**
     * @param $image
     * @return string
     * @throws \Exception
     */
    public function delete($image): string
    {
        //images exists ??
        if($result = file_get_contents('images/'.$image)) {
            unlink('images/'.$image);
            return $result;
        }
        throw new \Exception('Image does Not Exists use GET action to list images');
    }

    /**
     * @param $image
     * @return int
     * @throws \Exception
     */
    public function save($image): int
    {
        $downloadedImage = file_get_contents($image);
        if($saveResult = file_put_contents('images/'.basename($image), $downloadedImage)) {
            return $saveResult;
        }
        throw new \Exception('image was not saved'.$saveResult);
    }
}