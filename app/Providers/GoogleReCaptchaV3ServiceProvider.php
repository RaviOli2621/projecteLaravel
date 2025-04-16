<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use TimeHunter\LaravelGoogleReCaptchaV3\Providers\GoogleReCaptchaV3ServiceProvider as BaseProvider;

class GoogleReCaptchaV3ServiceProvider extends ServiceProvider
{
    /**
     * Registra cualquier servicio en el contenedor.
     *
     * @return void
     */
    public function register()
    {
        // Registra el ServiceProvider base de reCAPTCHA
        $this->app->register(BaseProvider::class);
    }

    /**
     * Realiza las tareas de inicialización después de que todos los servicios hayan sido registrados.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
