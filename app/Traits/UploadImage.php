<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;

trait UploadImage
{
    public function uploadImage(UploadedFile $image): string
    {
        $fileName = $image->getClientOriginalName();
        $image->move(env('PATH_TO_ASSETS'), $fileName);

        return $fileName;
    }


}
