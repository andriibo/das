<?php

namespace Database\Factories;

use App\Enums\LeagueIsEnabledEnum;
use App\Enums\LeagueRecentlyEnabledEnum;
use App\Enums\LeagueSportIdEnum;
use App\Models\League;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\League>
 */
class LeagueFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = League::class;

    /**
     * The number of models that should be generated.
     *
     * @var null|int
     */
    protected $count = 1;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'alias' => $this->faker->unique()->text(5),
            'name' => $this->faker->title,
            'season' => $this->faker->year(),
            'sport_id' => $this->faker->randomElement(LeagueSportIdEnum::values()),
            'is_enabled' => $this->faker->randomElement(LeagueIsEnabledEnum::values()),
            'date_updated' => $this->faker->dateTime(),
            'order' => 0,
            'config_id' => 1,
            'recently_enabled' => $this->faker->randomElement(LeagueRecentlyEnabledEnum::values()),
        ];
    }
}
