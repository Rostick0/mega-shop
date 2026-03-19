<?php

namespace App\Providers;

use App\Modules\Auth\Infrastructure\Persistence\IlluminateFacadeGenerateUuid;
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
            \App\Modules\User\Domain\Repositories\UserRepositoryInterface::class,
            \App\Modules\User\Infrastructure\Persistence\EloquentUserRepository::class
        );

        $this->app->bind(
            \App\Modules\Cart\Domain\Repositories\CartRepositoryInterface::class,
            \App\Modules\Cart\Infrastructure\Repository\CacheCartRepository::class
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
                $user = new \App\Modules\Shared\Infrastructure\Eloquent\UserModel();

                $user->id = $request->header('X-User-Id');
                $user->email = $request->header('X-Email');

                return $user;
            } catch (\Exception $th) {
                // Log::error($th);
                return null;
            }
        });
    }
}
