<?php

namespace App\Services;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ImageService
{
    /**
     * Process and save an image.
     *
     * @param \Illuminate\Http\UploadedFile $file
     * @param string $folder
     * @param int $scaleWidth
     * @return string $path
     */
    public static function processAndSaveImage($file, $folder = 'teams', $scaleWidth = 800)
    {
        // Generate a unique filename
        $filename = time() . '_' . uniqid() . '.' . $file->extension();
        //$filename = time() . '.' . $file->extension();

        // Define the path to save the image
        $directory = public_path("/images/{$folder}/");

        // Ensure the directory exists
        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        // Move the uploaded file to the designated directory
        $path = $file->move($directory, $filename);

        // Skip image processing for .ico files
        // if ($file->extension() === 'ico') {
        //     return $filename;
        // }

        // Create an ImageManager instance with the Gd driver
        $manager = new ImageManager(Driver::class);

        // Create an image instance from the file path
        $image = $manager->read($path);

        // Scale the image down to the specified width
        $image = $image->scaleDown(width: $scaleWidth);

        // Save the resized image
        $image->save($path);

        // Return the path to the saved image
        return $filename;
    }
}
