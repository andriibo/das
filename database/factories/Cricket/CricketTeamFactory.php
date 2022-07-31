<?php

namespace Database\Factories\Cricket;

use App\Enums\FeedTypeEnum;
use App\Models\Cricket\CricketTeam;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cricket\CricketTeam>
 */
class CricketTeamFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CricketTeam::class;

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
            'feed_id' => $this->faker->text(100),
            'name' => $this->faker->company,
            'nickname' => $this->faker->text(50),
            'alias' => $this->faker->text(30),
            'feed_type' => $this->faker->randomElement(FeedTypeEnum::names()),
        ];
    }
}
