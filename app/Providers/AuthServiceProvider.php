<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;
use Illuminate\Support\Facades\Config;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        $tokenLifetime = Config::get('app.token_lifetime');
        Passport::routes();
        Passport::tokensExpireIn(Carbon::now()->addDays($tokenLifetime));
        Passport::refreshTokensExpireIn(Carbon::now()->addDays($tokenLifetime));
        Passport::personalAccessTokensExpireIn(Carbon::now()->addDays($tokenLifetime));
    }
}
