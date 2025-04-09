<?php

namespace Database\Factories;

use App\Models\Account;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DoctorProfile>
 */
class DoctorProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => Account::where('role', 'doctor')->inRandomOrder()->first()->id,
            'specialization' => $this->faker->randomElement(['Dermatology', 'General Medicine']),
            'license_number' => $this->faker->bothify('LIC-####'),
            'license_file_path' => $this->faker->imageUrl(),
            'diploma_file_path' => $this->faker->imageUrl(),
            'certification' => $this->faker->sentence,
            'current_institution' => $this->faker->company,
            'years_of_experience' => $this->faker->numberBetween(1, 30),
            'work_history' => $this->faker->paragraph,
            'publications' => $this->faker->sentence,
        ];

    }
}
