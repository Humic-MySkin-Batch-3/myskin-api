<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\DoctorProfile;
use App\Models\Submission;
use Illuminate\Database\Seeder;

class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run() {
        Account::factory()
            ->count(10)
            ->state(['role' => 'doctor'])
            ->has(DoctorProfile::factory(), 'doctorProfile')
            ->create();

        Account::factory()
            ->count(10)
            ->state(['role' => 'patient'])
            ->create();
    }
}
