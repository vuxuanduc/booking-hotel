<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Hotel>
 */
class HotelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name_hotel' => fake()->text(25) ,
            'address' => fake()->text(50) , 
            'phone' => fake()->phoneNumber() ,
            'email' => fake()->email() ,
            'number_views' =>fake()->numberBetween(0 , 100) ,
            'status' => fake()->numberBetween(1 , 2) ,
        ];
    }
}
