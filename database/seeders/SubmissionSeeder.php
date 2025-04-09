<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\Submission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubmissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $patients = Account::where('role', 'patient')->get();
        $doctors = Account::where('role', 'doctor')->get();

        foreach ($patients as $patient) {
            Submission::factory()
                ->count(rand(1, 3))
                ->create([
                    'patient_id' => $patient->id,
                    'doctor_id' => $doctors->random()->id
                ]);
        }
    }
}
