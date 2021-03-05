<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Expenses\Entities\Expense;

class ExpenseFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Expense::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'code' => generateCode('expenses'),
            'client_id' => $this->faker->numberBetween(1, 10),
            'project_id' => $this->faker->numberBetween(1, 10),
            'tax' => $this->faker->randomFloat(2, 0, 10),
            'amount' => $this->faker->randomFloat(2, 100, 1000),
            'category' => \App\Entities\Category::whereModule('expenses')->inRandomOrder()->first()->id,
            'is_visible' => $this->faker->numberBetween(0, 1),
            'vendor' => $this->faker->company,
            'expense_date' => now()->subDays(rand(1, 30)),
            'currency' => 'USD',
            'user_id' => $this->faker->numberBetween(1, 5),
        ];
    }
}
