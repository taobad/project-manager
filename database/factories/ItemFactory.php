<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Items\Entities\Item;

class ItemFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Item::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'tax_rate' => $this->faker->randomFloat(2, 1, 20),
            'name' => $this->faker->sentence(3),
            'description' => $this->faker->text(25),
            'quantity' => $this->faker->numberBetween(1, 10),
            'unit_cost' => $this->faker->randomFloat(2, 50, 200),
        ];
    }
}
