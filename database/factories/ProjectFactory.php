<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Projects\Entities\Project;

class ProjectFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Project::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'code' => generateCode('projects'),
            'name' => $this->faker->company . ' Project',
            'currency' => 'USD',
            'description' => $this->faker->text(800),
            'client_id' => $this->faker->numberBetween(1, 10),
            'estimate_hours' => $this->faker->randomFloat(2, 30, 100),
            'hourly_rate' => $this->faker->randomFloat(2, 10, 100),
            'start_date' => now(),
            'due_date' => now()->addDays(rand(3, 90)),
            'progress' => 0,
            'manager' => 1,
            'billing_method' => 'hourly_project_rate',
        ];
    }
}
