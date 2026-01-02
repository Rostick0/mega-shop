<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            \App\Modules\Product\Domain\Repositories\ProductRepositoryInterface::class,
            \App\Modules\Product\Infrastructure\Persistence\EloquentProductRepository::class
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
