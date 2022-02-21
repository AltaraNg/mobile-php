<?php

namespace App\Providers;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

use function Ramsey\Uuid\v1;

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

        Gate::define('is-verfied', function (Customer $customer) {
            $verification = $customer->verification;
           return collect($verification->toArray())
            ->except(['id', 'cusmer_id', 'created_at', 'updated_at'])
            ->every(function ($value)
            {
              $value > 0;
            });
        });
    }
}
