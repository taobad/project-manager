<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Creditnotes\Entities\CreditNote;

class CreditNoteFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CreditNote::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'reference_no' => generateCode('credits'),
            'client_id' => $this->faker->numberBetween(1, 10),
            'terms' => $this->faker->text(300),
            'notes' => $this->faker->text(300),
            'currency' => 'USD',
            'tax' => 0,
        ];
    }
}
