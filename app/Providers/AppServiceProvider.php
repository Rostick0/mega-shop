<?php

namespace App\Providers;

use App\Modules\Auth\Infrastructure\Service\JwtTokenService;
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
            \App\Modules\Auth\Application\Contract\PasswordHasherInterface::class,
            \App\Modules\Auth\Infrastructure\Hashing\LaravelPasswordHasher::class
        );

        $this->app->bind(
            \App\Modules\Auth\Application\Contract\TokenServiceInterface::class,
            fn() =>
            new \App\Modules\Auth\Infrastructure\Service\JwtTokenService(
                config('jwt.secret')
            )
        );

        $this->app->bind(
            \App\Modules\Auth\Domain\Repositories\AuthRepositoryInterface::class,
            \App\Modules\Auth\Infrastructure\Persistence\EloquentAuthRepository::class
        );

        $this->app->bind(
            \App\Modules\Auth\Application\Contract\CurrentUserProviderInterface::class,
            \App\Modules\Auth\Infrastructure\Provider\LaravelCurrentUserProvider::class
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
                $jwt = new JwtTokenService(config('jwt.secret'));

                $tokenPayload = $jwt->parseAccessToken($request->bearerToken() ?? '');

                return \App\Modules\User\Infrastructure\Eloquent\UserModel::find((int) $tokenPayload->userId)->first();
            } catch (\Exception $th) {
                // Log::error($th);
                return null;
            }
        });
    }
}
