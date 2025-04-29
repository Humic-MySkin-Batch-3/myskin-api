<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoctorProfile extends Model
{
    /** @use HasFactory<\Database\Factories\DoctorProfileFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'specialization',
        'license_number',
        'license_file_path',
        'diploma_file_path',
        'certification',
        'current_institution',
        'work_history',
        'publications',
        'practice_address'
    ];

    public function account() {
        return $this->hasOne(Account::class, 'user_id');
    }
}
