<?php

namespace App\Providers;

use App\Auth\UserProvider;
use App\Hashing\IdCardHasher;
use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Auth;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //注册provider
        Auth::provider(
            'e8', function ($app) {
            return new UserProvider(
                new IdCardHasher(),
                User::class
            );
        }
        );
    }
}
