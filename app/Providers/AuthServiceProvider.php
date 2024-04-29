<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */


public function boot()
{
    $this->registerPolicies();

    // Define your gates here
    Gate::define('manage-friend-request', function (User $user, $friendId) {
        return $user->receivedRequests()->where('id', $friendId)->exists();
    });

    Gate::define('manage-friendship', function (User $user, $friendId) {
        return $user->friends()->where('id', $friendId)->exists();
    });
}

}
