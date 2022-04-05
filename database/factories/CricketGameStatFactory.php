<?php

namespace Database\Factories;

use App\Models\CricketGameStat;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CricketTeam>
 */
class CricketGameStatFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CricketGameStat::class;

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
            'raw_stat' => [],
        ];
    }
}
