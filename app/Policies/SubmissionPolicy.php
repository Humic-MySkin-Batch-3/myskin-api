<?php

namespace App\Policies;

use App\Models\Submission;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class SubmissionPolicy
{
    public function viewAny($user)
    {
        // pasien & dokter boleh lihat submission…
        return in_array($user->role, ['patient','doctor', 'admin']);
    }
    public function view($user, Submission $s)
    {
        if($user->role==='patient'){
            return $s->patient_id === $user->id;
        }
        if($user->role==='doctor' || $user->role==='admin'){
            // dokter lihat semua (atau tambahkan filter assigned/idempot)
            return true;
        }
        return false;
    }
    public function create($user)
    {
        return $user->role==='patient' || $user->role==='admin';
    }
    public function update($user, Submission $s)
    {
        return $user->role==='doctor' || $user->role==='admin';
    }
    public function delete($user, Submission $s)
    {
        return $user->role==='doctor' || $user->role==='admin';
    }


    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Submission $submission): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Submission $submission): bool
    {
        return false;
    }
}
