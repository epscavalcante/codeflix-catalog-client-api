<?php

namespace App\Providers;

use App\Adapters\ElasticsearchClientAdapter;
use Core\Domain\Repository\CastMemberRepository;
use Core\Domain\Repository\CategoryRepository;
use Core\Infra\Contracts\ElasticsearchClientInterface;
use Core\Infra\Repository\CastMemberElasticsearchRepository;
use Core\Infra\Repository\CategoryElasticsearchRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(
            ElasticsearchClientInterface::class,
            ElasticsearchClientAdapter::class
        );

        $this->app->singleton(
            CategoryRepository::class,
            CategoryElasticsearchRepository::class
        );

        $this->app->singleton(
            CastMemberRepository::class,
            CastMemberElasticsearchRepository::class
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
