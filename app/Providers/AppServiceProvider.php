<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Session;
use App\Models\User;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Optimize session configuration for custom user model
        Config::set('session.driver', 'file');
        Config::set('session.lifetime', 120);
        Config::set('session.expire_on_close', false);
        Config::set('session.encrypt', true);
        Config::set('session.same_site', null);
        
        // Configure auth to use custom user model properly
        Auth::provider('usuaris', function ($app, array $config) {
            return new \Illuminate\Auth\EloquentUserProvider(
                $app['hash'],
                User::class
            );
        });
    }
}
