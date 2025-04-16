<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use TimeHunter\LaravelGoogleReCaptchaV3\Facades\GoogleReCaptchaV3;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->register(\TimeHunter\LaravelGoogleReCaptchaV3\Providers\GoogleReCaptchaV3ServiceProvider::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Recaptcha v3 validation
        Validator::extend('recaptchav3', function ($attribute, $value, $parameters, $validator) {
            $action = $parameters[0] ?? 'default';
            $minScore = $parameters[1] ?? 0.5;
            
            $response = GoogleReCaptchaV3::verifyResponse($value, request()->ip());
            
            return $response->isSuccess() && 
                   $response->getAction() === $action && 
                   $response->getScore() >= $minScore;
        }, 'La verificación de seguridad ha fallado. Por favor, inténtalo de nuevo.');
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
