<?php

namespace App\Providers;

use App\Models\Account;
use App\Models\Submission;
use App\Models\DoctorProfile;
use App\Policies\AccountPolicy;
use App\Policies\SubmissionPolicy;
use App\Policies\DoctorProfilePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Map model → policy
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Account::class       => AccountPolicy::class,
        Submission::class    => SubmissionPolicy::class,
        DoctorProfile::class => DoctorProfilePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Gate::define('access-doctor-section', fn($user)=> $user->role==='doctor' || $user->role==='admin');
        $this->registerPolicies();
    }
}
