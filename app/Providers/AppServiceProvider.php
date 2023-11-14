<?php

namespace App\Providers;

use App\Adapters\ElasticsearchClientAdapter;
use Core\Domain\Repository\CategoryRepository;
use Core\Infra\ElasticsearchClientInterface;
use Core\Infra\Repository\CategoryElasticsearchRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // $this->app->singleton(Client::class, function () {
        //     return ClientBuilder::create()
        //         ->setHosts([Config::get('elasticsearch.hosts')])
        //         ->setBasicAuthentication(
        //             Config::get('elasticsearch.username'),
        //             Config::get('elasticsearch.password')
        //         )
        //         ->build();
        // });

        $this->app->singleton(
            ElasticsearchClientInterface::class,
            ElasticsearchClientAdapter::class
        );

        $this->app->singleton(
            CategoryRepository::class,
            CategoryElasticsearchRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
