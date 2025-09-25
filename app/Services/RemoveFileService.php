<?php

namespace App\Services;

use Illuminate\Support\Facades\File;

class RemoveFileService
{


    public static function remove($folder, $filename)
    {
        if (File::exists(public_path('images/' . $folder . '/' . $filename))) {
            File::delete(public_path('images/' . $folder . '/' . $filename));
        }
    }
}
