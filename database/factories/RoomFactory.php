<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Room>
 */
class RoomFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'hotel_id' => rand(1 , 20) ,
            'room_type_id' => rand(1 , 6) ,
            'room_name' => fake()->text(30) ,
            'number_people' => rand(1 , 5) ,
            'description' => fake()->text(500) ,
            'price' => fake()->randomFloat(2 , 0 , 999999.99) ,
            'status' => rand(1 , 2),
        ];
    }
}
