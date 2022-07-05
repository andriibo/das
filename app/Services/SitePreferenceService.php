<?php

namespace App\Services;

use App\Enums\Contests\TypeEnum;
use App\Repositories\SitePreferenceRepository;

class SitePreferenceService
{
    public function __construct(private readonly SitePreferenceRepository $sitePreferenceRepository)
    {
    }

    public function getSiteFee(int|float|null $companyTake, string $contestType): int|float|string
    {
        if (null !== $companyTake) {
            return $companyTake;
        }

        return (TypeEnum::user->name === $contestType)
            ? $this->getSettingByName('user_contest_site_fee')
            : $this->getSettingByName('site_fee');
    }

    public function getSettingByName(string $name): string
    {
        $setting = $this->sitePreferenceRepository->getSetting();

        return $setting->{$name};
    }
}
