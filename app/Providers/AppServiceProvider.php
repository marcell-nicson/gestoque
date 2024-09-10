<?php

namespace App\Providers;

use App\Services\ChatGPTService;
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
        //
    }
}
