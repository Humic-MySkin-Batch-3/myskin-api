<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Account>
 */
class AccountFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected static ?string $password;
    public function definition(): array
    {
        $role = $this->faker->randomElement(['patient', 'doctor']);
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->phoneNumber(),
            'dob' => fake()->date(),
            'role' => $role,
            'password' => static::$password ??= Hash::make('password'),
        ];
    }

    public function patient() {
        return $this->state([
            'role' => 'patient'
        ]);
    }

    public function doctor() {
        return $this->state([
            'role' => 'doctor'
        ]);
    }
}
