<?php

namespace Database\Factories;

use App\Enums\CricketFeedTypeEnum;
use App\Enums\CricketPlayerInjuryStatusEnum;
use App\Enums\CricketPlayerSportEnum;
use App\Models\CricketPlayer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CricketPlayer>
 */
class CricketPlayerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CricketPlayer::class;

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
            'feed_type' => $this->faker->randomElement(CricketFeedTypeEnum::names()),
            'feed_id' => $this->faker->text(100),
            'sport' => $this->faker->randomElement(CricketPlayerSportEnum::names()),
            'first_name' => $this->faker->text(50),
            'last_name' => $this->faker->text(50),
            'injury_status' => $this->faker->randomElement(CricketPlayerInjuryStatusEnum::names()),
        ];
    }
}
