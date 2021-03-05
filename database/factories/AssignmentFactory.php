<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Teams\Entities\Assignment;

class AssignmentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Assignment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $arr = ['Modules\Projects\Entities\Project', 'Modules\Tasks\Entities\Task'];
        return [
            'user_id' => $this->faker->numberBetween(1, 10),
            'assignable_id' => $this->faker->numberBetween(1, 10),
            'assignable_type' => array_random($arr),
        ];
    }
}
