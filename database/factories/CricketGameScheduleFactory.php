<?php

namespace Database\Factories;

use App\Const\CricketGameScheduleConst;
use App\Enums\CricketFeedTypeEnum;
use App\Enums\CricketGameScheduleStatusEnum;
use App\Enums\CricketGameScheduleTypeEnum;
use App\Models\CricketGameSchedule;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CricketGameSchedule>
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
            'has_final_box' => $this->faker->randomElement(CricketGameScheduleConst::HAS_FINAL_BOX_OPTIONS),
            'is_data_confirmed' => $this->faker->randomElement(CricketGameScheduleConst::IS_DATA_CONFIRMED_OPTIONS),
            'home_team_score' => $this->faker->text(20),
            'away_team_score' => $this->faker->text(20),
            'is_fake' => $this->faker->randomElement(CricketGameScheduleConst::IS_FAKE_OPTIONS),
            'is_salary_available' => $this->faker->randomElement(CricketGameScheduleConst::IS_SALARY_AVAILABLE_OPTIONS),
            'feed_type' => $this->faker->randomElement(CricketFeedTypeEnum::names()),
            'status' => $this->faker->randomElement(CricketGameScheduleStatusEnum::values()),
            'type' => $this->faker->randomElement(CricketGameScheduleTypeEnum::values()),
        ];
    }
}
