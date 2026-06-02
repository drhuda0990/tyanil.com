<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        \App\PaymentRequest::class => \App\Policies\PaymentRequestPolicy::class,
        \App\PaymentResponse::class => \App\Policies\PaymentResponsePolicy::class,
        \App\StoreNotification::class => \App\Policies\StoreNotificationPolicy::class,
        //  'App\User' => 'App\Policies\UserPolicy',

         
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
