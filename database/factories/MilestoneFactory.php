<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Milestones\Entities\Milestone;

class MilestoneFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Milestone::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $arr = ['Planning', 'Design', 'Development', 'Launch', 'Follow Up', 'Research'];
        return [
            'milestone_name' => array_random($arr),
            'description' => $this->faker->paragraph,
            'start_date' => today(),
            'due_date' => now()->addDays(rand(3, 30)),
        ];
    }
}
