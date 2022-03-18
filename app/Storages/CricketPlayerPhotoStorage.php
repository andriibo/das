<?php

namespace App\Storages;

final class CricketPlayerPhotoStorage extends FileSystemStorage
{
    public function storageName(): string
    {
        return 'cricket-player-photos';
    }
}
