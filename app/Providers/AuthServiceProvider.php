<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $payload = json_decode(Auth::token());
        $realmAccess = $payload->realm_access ?? null;
        $realmAccessRoles = $realmAccess->roles ?? [];

        Gate::define('manage-catalog', fn () => in_array('manage-catalog', $realmAccessRoles));
        Gate::define('manage-catalog-categories', fn () => in_array('manage-catalog-categories', $realmAccessRoles));
        Gate::define('manage-catalog-cast-members', fn () => in_array('manage-catalog-cast-members', $realmAccessRoles));
        Gate::define('manage-catalog-genres', fn () => in_array('manage-catalog-genres', $realmAccessRoles));
        Gate::define('manage-catalog-cast-videos', fn () => in_array('manage-catalog-videos', $realmAccessRoles));
    }
}
