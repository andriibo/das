<?php

namespace Database\Factories;

use App\Enums\IsEnabledEnum;
use App\Enums\SportIdEnum;
use App\Models\ActionPoint;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\League>
 */
class ActionPointFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ActionPoint::class;

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
            'name' => $this->faker->word,
            'sport_id' => $this->faker->randomElement(SportIdEnum::values()),
            'values' => '[]',
            'sort_order' => 0,
            'is_enabled' => $this->faker->randomElement(IsEnabledEnum::values()),
            'title' => $this->faker->word,
            'alias' => $this->faker->unique()->text(5),
            'game_log_template' => $this->faker->word,
        ];
    }
}
