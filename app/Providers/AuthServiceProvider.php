<?php

namespace App\Providers;

use App\ClientProduct;
use App\Client;
use App\Policies\Client\OfferPolicy;
use App\Policies\Client\SubClientPolicy;
use Laravel\Passport\Passport;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Schema;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
        ClientProduct::class => OfferPolicy::class,
        Client::class => SubClientPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        Passport::routes();

        Schema::defaultStringLength(191);
    }
}
