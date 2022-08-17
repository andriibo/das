<?php

namespace App\Repositories;

use App\Models\SitePreference;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class SitePreferenceRepository
{
    /**
     * @throws ModelNotFoundException
     */
    public function getSetting(): SitePreference
    {
        return SitePreference::query()->firstOrFail();
    }
}
