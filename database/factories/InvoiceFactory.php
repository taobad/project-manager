<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Invoices\Entities\Invoice;

class InvoiceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Invoice::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'reference_no' => generateCode('invoices'),
            'title' => $this->faker->name . ' Website Project',
            'client_id' => $this->faker->numberBetween(1, 20),
            'discount' => $this->faker->randomFloat(2, 0, 10),
            'is_visible' => $this->faker->numberBetween(0, 1),
            'due_date' => now()->addDays(rand(3, 90))->toDateTimeString(),
            'currency' => 'USD',
            'is_visible' => 1,
            'sent_at' => now(),
            'notes' => $this->faker->text(300),
            'gateways' => ['paypal' => 'active', 'bank' => 'active'],
            'created_at' => now()->format(config('system.preferred_date_format')),
        ];
    }
}
