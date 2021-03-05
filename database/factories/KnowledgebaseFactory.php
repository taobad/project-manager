<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Knowledgebase\Entities\Knowledgebase;

class KnowledgebaseFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Knowledgebase::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'group' => \App\Entities\Category::whereModule('knowledgebase')->inRandomOrder()->first()->id,
            'subject' => $this->faker->sentence(6),
            'description' => $this->faker->text(800),
            'user_id' => $this->faker->numberBetween(1, 5),
        ];
    }
}
