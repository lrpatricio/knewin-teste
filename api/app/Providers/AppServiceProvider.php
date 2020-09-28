<?php

namespace App\Providers;

use App\Repositories\NoticiaRepository;
use Elasticsearch\Client;
use Elasticsearch\ClientBuilder;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        /**
         * Regitrar intanciamento padrão para noticia Repository pegando configuração
         * para conexão ao elasticSearch
         */
        $this->app->bind(NoticiaRepository::class, function ($app) {
            return new NoticiaRepository($app->make(Client::class));
        });
        $this->bindESClient();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Regitrar "builder" para o Client do elasticSearch
     */
    private function bindESClient()
    {
        $this->app->bind(Client::class, function ($app) {
            return ClientBuilder::create()
                ->setHosts($app['config']->get('services.es.host'))
                ->build();
        });
    }
}
