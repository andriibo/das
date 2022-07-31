<?php

namespace Database\Factories\Cricket;

use App\Enums\CricketUnit\PositionEnum;
use App\Models\Cricket\CricketUnit;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cricket\CricketUnit>
 */
class CricketUnitFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CricketUnit::class;

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
            'position' => $this->faker->randomElement(PositionEnum::values()),
        ];
    }
}
