<?php

namespace App\Providers;

use App\Events\ProdutoCriado;
use App\Listeners\EnviarNotificacaoProdutoCriado;
use App\Services\ChatGPTService;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(ChatGPTService::class, function ($app) {
            return new ChatGPTService(env('OPENAI_API_KEY')); // Supondo que a chave da API esteja no arquivo .env
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Event::listen(
            ProdutoCriado::class,
            [EnviarNotificacaoProdutoCriado::class, 'handle']
        );
    }
}
