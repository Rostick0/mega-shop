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

        $this->app->bind(
            \App\Modules\User\Domain\Repositories\UserRepositoryInterface::class,
            \App\Modules\User\Infrastructure\Persistence\EloquentUserRepository::class
        );

        $this->app->bind(
            \App\Modules\Auth\Application\Entity\PasswordHasherInterface::class,
            \App\Modules\Auth\Infrastructure\Hashing\LaravelPasswordHasher::class
        );

        $this->app->bind(
            \App\Modules\Auth\Application\Entity\TokenServiceInterface::class,
            fn() =>
            new \App\Modules\Auth\Infrastructure\Service\JwtTokenService(
                config('jwt.secret')
            )
        );

        // $this->app->bind(
        //     \App\Modules\Auth\Infrastructure\Service\JwtTokenService::class,
        //     fn() =>
        //     new \App\Modules\Auth\Infrastructure\Service\JwtTokenService(
        //         config('jwt.secret')
        //     )
        // );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        \Illuminate\Support\Facades\Auth::viaRequest('jwt', function (\Illuminate\Http\Request $request) {
            try {
                $tokenPayload = \Firebase\JWT\JWT::decode($request->bearerToken() ?? '', new \Firebase\JWT\Key(config('jwt.secret'), 'HS256'));

                return \App\Modules\User\Infrastructure\Eloquent\UserModel::find($tokenPayload)->first();
            } catch (\Exception $th) {
                // Log::error($th);
                return null;
            }
        });
    }
}
