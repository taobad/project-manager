<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Contracts\Entities\Contract;

class ContractFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Contract::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'client_id' => $this->faker->numberBetween(1, 10),
            'contract_title' => $this->faker->company . ' Contract',
            'start_date' => now()->format(config('system.preferred_date_format')),
            'end_date' => now()->addDays(rand(3, 90)),
            'expiry_date' => $this->faker->numberBetween(1, 14),
            'hourly_rate' => $this->faker->randomFloat(2, 10, 20),
            'payment_terms' => $this->faker->numberBetween(1, 14),
            'termination_notice' => $this->faker->numberBetween(5, 14),
            'late_fee_percent' => 1,
            'description' => $this->faker->text(800),
            'currency' => 'USD',
            'services' => $this->faker->sentence(6),
            'cancelation_fee' => $this->faker->randomFloat(2, 10, 15),
            'license_owner' => array_random(['freelancer', 'client']),
            'client_rights' => $this->faker->text(200),
            'user_id' => 1,
            'template_id' => 2,
        ];
    }
}
