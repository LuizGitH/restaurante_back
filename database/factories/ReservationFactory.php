<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\reservation>
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
            'Customer_id' => $this->faker->numberBetween(1, 20),
            'Reservation_date' => $this->faker->date(),
            'number_people' => $this->faker->numberBetween(1, 10),
        ];
    }
}
