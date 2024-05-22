<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reservation>
 */
class ReservationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => rand(1 , 10) ,
            'room_id' => rand(1 , 100) ,
            'status_id' => rand(1 , 5) ,
            'reservation_date' => fake()->dateTime() ,
            'check_in_date' => fake()->date() ,
            'check_out_date' => fake()->date() ,
            'price' => fake()-> randomFloat(2 , 0 , 999999.99),
            'total_amount' => fake()-> randomFloat(2 , 0 , 999999.99),
        ];
    }
}
