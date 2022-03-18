<?php

namespace App\Storages;

use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;

abstract class FileSystemStorage
{
    abstract public function storageName(): string;

    public function storage(): Filesystem
    {
        return Storage::disk($this->storageName());
    }
}
