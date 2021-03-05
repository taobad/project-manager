<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Tickets\Entities\Ticket;

class TicketFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Ticket::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'code' => generateCode('tickets'),
            'subject' => $this->faker->firstNameMale . ' Ticket',
            'body' => $this->faker->text(800),
            'department' => \App\Entities\Department::inRandomOrder()->first()->deptid,
            'user_id' => $this->faker->numberBetween(1, 20),
            'priority' => \App\Entities\Priority::inRandomOrder()->first()->id,
            'status' => \App\Entities\Status::whereStatus('open')->first()->id,
            'assignee' => 1,
        ];
    }
}
