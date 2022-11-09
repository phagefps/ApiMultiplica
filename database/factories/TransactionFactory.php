<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id' => rand(1, 50),
            'amount' => fake()->randomFloat(2, 1, 9999),
            'type' => fake()->randomElement(['deposit', 'withdraw']), // deposit, withdraw
            'message' => fake()->text(),
            'created_at' => fake()->dateTimeBetween($startDate = '-3 month', $endDate = 'now'),
            'updated_at' => null
        ];
    }
}
