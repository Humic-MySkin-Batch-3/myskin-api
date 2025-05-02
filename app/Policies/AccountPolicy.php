<?php

namespace App\Policies;

use App\Models\Account;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class AccountPolicy
{
    public function viewAny($user)
    {
        // hanya admin boleh lihat daftar akun
        return in_array($user->role, ['admin', 'patient']);
    }
    public function view($user, Account $account)
    {
        // admin boleh lihat semua, user bisa lihat diri sendiri
        return $user->role==='admin' || $user->id === $account->id;
    }
    public function update($user, Account $account)
    {
        // admin boleh update semua, user bisa update diri sendiri
        return $user->role==='admin' || $user->id === $account->id;
    }
    public function delete($user, Account $account)
    {
        // hanya admin
        return $user->role==='admin';
    }
    public function create($user)
    {
        // pembuatan akun via API hanya lewat register
        return false;
    }


    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Account $account): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Account $account): bool
    {
        return false;
    }
}
