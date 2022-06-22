<?php

namespace App\Helpers;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class FileHelper
{
    public static function getPublicUrl(?string $fileName): ?string
    {
        if (is_null($fileName)) {
            return null;
        }

        return Storage::disk('s3')->url($fileName);
    }

    public static function createFromUrl(string $url, string $originalName = '', string $mimeType = null, int $error = null, bool $test = false): UploadedFile
    {
        if (!$stream = @fopen($url, 'r')) {
            throw new \Exception($url);
        }

        $tempFile = tempnam(sys_get_temp_dir(), 'url-file-');

        file_put_contents($tempFile, $stream);

        return new UploadedFile($tempFile, $originalName, $mimeType, $error, $test);
    }
}
