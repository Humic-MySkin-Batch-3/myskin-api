<?php

namespace App\Policies;

use App\Models\DoctorProfile;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class DoctorProfilePolicy
{
    public function viewAny($user)
    {
        // hanya dokter & admin yg butuh list profil dokter
        return in_array($user->role,['doctor','admin']);
    }
    public function view($user, DoctorProfile $p)
    {
        // dokter hanya lihat profil dirinya sendiri
        return $user->role==='doctor' && $p->user_id === $user->id || $user->role==='admin';
    }
    public function update($user, DoctorProfile $p)
    {
        return $user->role==='doctor' && $p->user_id === $user->id || $user->role==='admin';
    }
    public function delete($user, DoctorProfile $p)
    {
        // biasanya nggak dihapus, tapi kalau perlu:
        return $user->role==='admin';
    }
    public function create($user)
    {
        // profil dokter dibuat otomatis waktu register doctor
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, DoctorProfile $doctorProfile): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, DoctorProfile $doctorProfile): bool
    {
        return false;
    }
}
