<?php

namespace Database\Factories;

use App\Enums\CricketGameSchedule\HasFinalBoxEnum;
use App\Enums\CricketGameSchedule\IsDataConfirmedEnum;
use App\Enums\CricketGameSchedule\IsFakeEnum;
use App\Enums\CricketGameSchedule\IsSalaryAvailableEnum;
use App\Enums\CricketGameSchedule\StatusEnum;
use App\Enums\CricketGameSchedule\TypeEnum;
use App\Enums\FeedTypeEnum;
use App\Models\Cricket\CricketGameSchedule;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cricket\CricketGameSchedule>
 */
class CricketGameScheduleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CricketGameSchedule::class;

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
            'game_date' => $this->faker->dateTime()->format('Y-m-d H:i:s'),
            'has_final_box' => $this->faker->randomElement(HasFinalBoxEnum::values()),
            'is_data_confirmed' => $this->faker->randomElement(IsDataConfirmedEnum::values()),
            'home_team_score' => $this->faker->text(20),
            'away_team_score' => $this->faker->text(20),
            'is_fake' => $this->faker->randomElement(IsFakeEnum::values()),
            'is_salary_available' => $this->faker->randomElement(IsSalaryAvailableEnum::values()),
            'feed_type' => $this->faker->randomElement(FeedTypeEnum::names()),
            'status' => $this->faker->randomElement(StatusEnum::values()),
            'type' => $this->faker->randomElement(TypeEnum::values()),
        ];
    }
}
