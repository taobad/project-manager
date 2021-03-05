<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Tasks\Entities\Task;

class TaskFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Task::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->company . ' Task',
            'description' => $this->faker->text(300),
            'project_id' => $this->faker->numberBetween(1, 10),
            'visible' => $this->faker->numberBetween(0, 1),
            'start_date' => now()->addDays(rand(1, 14)),
            'due_date' => now()->addDays(rand(14, 60)),
            'hourly_rate' => $this->faker->randomFloat(2, 0, 10),
            'progress' => $this->faker->numberBetween(0, 100),
            'user_id' => 1,
        ];
    }
}
