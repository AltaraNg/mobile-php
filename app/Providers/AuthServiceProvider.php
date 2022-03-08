<?php

namespace App\Providers;

use App\Helper\HttpResponseCodes;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\Access\Response;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('verified', function (Customer $customer) {
            $verification = $customer->verification;
            return collect($verification->toArray())
                ->except(['id', 'customer_id', 'created_at', 'updated_at'])
                ->every(function ($value) {
                    return $value > 0;
                })  ? Response::allow()
                : Response::deny('Only verified accounts can place request, Visit the showroom for further details', HttpResponseCodes::PERMISSION_DENIED);;
        });
    }
}
