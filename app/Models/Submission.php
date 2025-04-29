<?php

namespace App\Models;

use Database\Factories\SubmissionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    /** @use HasFactory<SubmissionFactory> */
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'doctor_id',
        'image_path',
        'complaint',
        'status',
        'diagnosis',
        'doctor_note',
        'submitted_at',
        'verified_at',
        'percentage',
    ];

    public function scopePending($q) { return $q->where('status','pending'); }
    public function scopeHistory($q) { return $q->where('status','!=','pending'); }


    public function patient()
    {
        return $this->belongsTo(Account::class, 'patient_id');
    }
    public function doctor() {
        return $this->belongsTo(Account::class, 'doctor_id');
    }
}
