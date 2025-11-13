<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route; // Importante ter o 'use Route'

class RouteServiceProvider extends ServiceProvider
{
    /**
     * O caminho para a rota "home" da sua aplicação.
     * Normalmente usado pelo middleware de autenticação ao redirecionar.
     */
    public const HOME = '/home'; // Você pode mudar isso se quiser

    /**
     * Define seus mapeamentos de rota para a aplicação.
     */
    public function boot(): void
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            // --- É ISSO QUE IMPORTA ---
            // Carrega seu arquivo de rotas de API
            Route::middleware('api')
                ->prefix('api') // Adiciona /api antes de tudo
                ->group(base_path('routes/api.php'));

            // Carrega seu arquivo de rotas Web
            Route::middleware('web')
                ->group(base_path('routes/web.php'));
            // --- FIM DO BLOCO ---
        });
    }

    /**
     * Configura os limitadores de taxa (rate limiting) para a aplicação.
     */
    protected function configureRateLimiting(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
    }
}