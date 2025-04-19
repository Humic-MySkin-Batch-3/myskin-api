<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Account extends Model
{
    /** @use HasFactory<\Database\Factories\AccountFactory> */
    use HasApiTokens, HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'dob',
        'role',
        'password',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'role' => 'string', // patient or doctor
        ];
    }

    public function submission()
    {
        return $this->hasMany(Submission::class, 'patient_id');
    }

    public function doctorProfile() {
        return $this->hasOne(DoctorProfile::class, 'user_id');
    }
}
