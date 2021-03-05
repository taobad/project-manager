<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Clients\Entities\Client;

class ClientFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Client::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $arr = ['3M.png', 'algolia.png', 'disney-min.jpg', 'docker-logo.png', 'apple.jpg',
            'dropbox.svg', 'ebay-logo-min.jpg', 'envato-logo.png', 'google.png', 'ibm-logo.jpg', 'intel.gif',
            'macdonalds-min.jpg', 'nike-min.png', 'paypal.png', 'pepsi-min.jpg', 'salesforce.png',
            'shell-min.jpg', 'soundcloud.png', 'tux_droid_1.jpg', 'twitter.png', 'visa-min.png',
        ];
        return [
            'code' => generateCode('clients'),
            'name' => $this->faker->company,
            'email' => $this->faker->safeEmail,
            'address1' => $this->faker->streetAddress,
            'website' => 'https://' . $this->faker->domainName,
            'city' => $this->faker->city,
            'state' => $this->faker->stateAbbr,
            'zip_code' => $this->faker->postcode,
            'phone' => $this->faker->e164PhoneNumber,
            'country' => $this->faker->country,
            'notes' => $this->faker->paragraph,
            'owner' => $this->faker->numberBetween(1, 5),
            'primary_contact' => $this->faker->numberBetween(1, 5),
            'logo' => array_random($arr),
        ];
    }
}
