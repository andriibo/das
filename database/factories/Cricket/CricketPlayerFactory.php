<?php

namespace Database\Factories\Cricket;

use App\Enums\CricketPlayer\InjuryStatusEnum;
use App\Enums\FeedTypeEnum;
use App\Models\Cricket\CricketPlayer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cricket\CricketPlayer>
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
            'feed_type' => $this->faker->randomElement(FeedTypeEnum::names()),
            'feed_id' => $this->faker->text(100),
            'first_name' => $this->faker->name('male'),
            'last_name' => $this->faker->name('male'),
            'injury_status' => $this->faker->randomElement(InjuryStatusEnum::names()),
        ];
    }
}
