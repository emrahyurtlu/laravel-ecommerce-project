<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => 2,
            'city' => $this->faker->city,
            'district' => $this->faker->city,
            'zipcode' => $this->faker->randomDigitNotZero(),
            'address' => $this->faker->address,
            'is_default' => $this->faker->boolean
        ];
    }
}
