<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Users\Entities\User;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'username' => $this->faker->unique()->userName,
            'email' => $this->faker->unique()->safeEmail,
            'name' => $this->faker->name,
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => str_random(10),
            'email_verified_at' => now(),
        ];
    }
    /**
     * Configure the model factory.
     *
     * @return $this
     */
    public function configure()
    {
        $avatars = ['avatar7.png', 'avatar8.png', 'avatar9.png', 'avatar10.png', 'avatar6.png', 'avatar5.jpg', 'avatar4.jpg', 'avatar3.jpg', 'avatar2.jpg', 'avatar1.jpeg'];
        return $this->afterCreating(function (User $user) use ($avatars) {
            $user->profile()->update([
                'avatar' => array_random($avatars),
                'company' => rand(0, 10),
                'job_title' => $this->faker->jobTitle,
                'use_gravatar' => 0,
                'hourly_rate' => $this->faker->numberBetween(3, 20),
                'skype' => $this->faker->unique()->userName,
                'twitter' => $this->faker->unique()->userName,
            ]);
        });
    }
}
