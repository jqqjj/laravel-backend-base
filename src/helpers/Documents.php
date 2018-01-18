<?php


namespace App\Helpers;

use Illuminate\Support\Facades\Storage;

class Documents
{
    public function getPublicPathSize($path)
    {
        $size = 0;
        $files = Storage::disk('local')->allFiles($path);
        foreach ($files as $file){
            $size += Storage::disk("local")->size($file);
        }
        return $size;
    }
}