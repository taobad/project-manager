<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Deals\Entities\Deal;

class DealFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Deal::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->company . ' Deal',
            'stage_id' => \App\Entities\Category::whereModule('deals')->inRandomOrder()->first()->id,
            'currency' => 'USD',
            'deal_value' => $this->faker->randomFloat(2, 10, 1000),
            'contact_person' => $this->faker->numberBetween(1, 5),
            'organization' => $this->faker->numberBetween(1, 10),
            'due_date' => now()->addDays(rand(3, 60)),
            'source' => \App\Entities\Category::whereModule('source')->inRandomOrder()->first()->id,
            'pipeline' => \App\Entities\Category::whereModule('pipeline')->inRandomOrder()->first()->id,
            'user_id' => $this->faker->numberBetween(1, 5),
        ];
    }
}
