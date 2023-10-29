<?php

namespace App\Helpers;


use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UploadHelper
{
    public static function getFileExtension($fileName, $request) {
        if (!$request->hasFile($fileName)) {
            return '';
        }

        $image = $request->file($fileName);
        return $image->getClientOriginalExtension();
    }

    public static function uploadFileOrigin($file, $uploadPath, $fileName, $request)
    {
        if (!$request->hasFile($fileName)) {
            return '';
        }

        $imageName = $file->getClientOriginalName();
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }

        $file->move($uploadPath, $imageName);
        return '/' . $uploadPath . $imageName;
    }

    public static function getOriginFile($fileName, $uploadPath, $request)
    {
        if (!$request->hasFile($fileName)) {
            return '';
        }

        $file = $request->file($fileName);
        return self::uploadFileOrigin($file, $uploadPath, $fileName, $request);
    }

    public static function handleUploadFile($fileName, $uploadPath, $request)
    {
        $fullPath = '';
        if (!$request->hasFile($fileName)) {
            return $fullPath;
        }
        $file = $request->file($fileName);
        $saveName = date('YmdHis') . '_' . sha1(Str::uuid()) . '.' . $file->getClientOriginalExtension();
        $fullPath = $uploadPath . $saveName;

        self::makeDirectoryByStorage($uploadPath);

        Storage::disk()->put($fullPath, file_get_contents($file));
        return $fullPath;
    }

    public static function handleDeleteFile($name, $request)
    {
        $fileDelete = $request->get($name);
        if (Storage::disk()->exists($fileDelete)) {
            Storage::disk()->delete($fileDelete);
        }
        return $fileDelete;
    }

    public static function handleRemoveFile(String $fileName) : void
    {
        if (empty($fileName)) {
            return ;
        }

        if (Storage::disk()->exists($fileName)) {
            Storage::disk()->delete($fileName);
        }
    }

    public static function makeDirectoryByStorage($directory) : bool
    {
        if (Storage::disk()->exists($directory)) {
            return false;
        }
        return Storage::disk()->makeDirectory($directory);
    }
}
