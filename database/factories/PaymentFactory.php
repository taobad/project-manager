<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Payments\Entities\Payment;

class PaymentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Payment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'invoice_id' => $this->faker->numberBetween(1, 10),
            'client_id' => $this->faker->numberBetween(1, 10),
            'payment_method' => \App\Entities\AcceptPayment::inRandomOrder()->first()->method_id,
            'currency' => 'USD',
            'payment_date' => now()->subDays(rand(1, 30)),
            'amount' => $this->faker->randomFloat(2, 600, 1000),
            'amount_formatted' => '',
        ];
    }
}
