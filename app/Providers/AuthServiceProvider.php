<?php

namespace App\Providers;

use App\Models\Employee;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

use App\Models\TimeSheet;
use App\Policies\EmployeePolicy;
use App\Policies\TimeSheetPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
        'App\Models\Employee' => 'App\Policies\EmployeePolicy',
        'App\Models\TimeSheet' => 'App\Policies\TimeSheetPolicy',
        'App\Models\User' => 'App\Policies\UserPolicy',
        'App\Models\Payment' => 'App\Policies\PaymentPolicy'
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::before(function ($user, $ability) {
            return $user->hasRole('superadmin') ? true : null;
        });
    }
}
