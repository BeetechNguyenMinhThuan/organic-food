<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;
use Nette\FileNotFoundException;

class Common
{
    public static function getImage($img)
    {
        try {
            if (empty($img)) {
                $image = asset('/images/img-default.jpg');
            } else {
                $image = Storage::disk(FILESYSTEM)->url($img);
            }
            return $image;
        } catch (FileNotFoundException $e) {
            return null;
        }
    }
}
