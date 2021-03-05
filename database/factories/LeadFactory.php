<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Leads\Entities\Lead;

class LeadFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Lead::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'job_title' => $this->faker->jobTitle,
            'company' => $this->faker->company,
            'mobile' => $this->faker->e164PhoneNumber,
            'email' => $this->faker->safeEmail,
            'address1' => $this->faker->address,
            'city' => $this->faker->city,
            'stage_id' => \App\Entities\Category::leads()->inRandomOrder()->first()->id,
            'lead_value' => $this->faker->randomFloat(2, 10, 1000),
            'country' => $this->faker->country,
            'website' => 'https://' . $this->faker->domainName,
            'due_date' => now()->addDays(rand(3, 60)),
            'source' => \App\Entities\Category::whereModule('source')->inRandomOrder()->first()->id,
            'sales_rep' => $this->faker->numberBetween(1, 5),
        ];
    }
}
