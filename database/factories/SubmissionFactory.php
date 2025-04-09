<?php

namespace Database\Factories;

use App\Models\Account;
use App\Models\Submission;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Submission>
 */
class SubmissionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Submission::class;

    public function definition(): array
    {
        return [
            'patient_id' => Account::where('role', 'patient')->inRandomOrder()->first()->id,
            'doctor_id' => Account::where('role', 'doctor')->inRandomOrder()->first()->id,
            'image_path' => $this->faker->imageUrl(),
            'complaint' => $this->faker->sentence,
            'status' => $this->faker->randomElement(['pending', 'verified', 'rejected']),
            'diagnosis' => $this->faker->randomElement(['Melanoma', 'Eczema', 'Psoriasis']),
            'doctor_note' => $this->faker->sentence,
            'submitted_at' => $this->faker->dateTime(),
            'verified_at' => now(),
        ];
    }
}
