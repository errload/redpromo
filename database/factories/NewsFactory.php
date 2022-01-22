<?php

namespace Database\Factories;

use Faker\Generator;
use Illuminate\Database\Eloquent\Factories\Factory;

class NewsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title'     => $this->faker->sentence(rand(3, 6)),
            'about'     => $this->faker->sentence(rand(20, 30)),
            'text'      => $this->faker->text(rand(600, 1800)),
            'picture'   => $this->faker->randomElement([
                '1.png', '2.png', '3.png', '4.png', '5.png'
            ]),
            'city'      => $this->faker->randomElement(['', 'moscow', 'nalchik']),
            'favorite'  => $this->faker->randomElement([true, false])
        ];
    }
}
