<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Estimates\Entities\Estimate;

class EstimateFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Estimate::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'reference_no' => generateCode('estimates'),
            'title' => $this->faker->name . ' Website Project',
            'client_id' => $this->faker->numberBetween(1, 10),
            'discount' => $this->faker->randomFloat(2, 0, 10),
            'is_visible' => $this->faker->numberBetween(0, 1),
            'due_date' => now()->addDays(rand(3, 90)),
            'currency' => 'USD',
            'notes' => $this->faker->text(300),
        ];
    }
}
