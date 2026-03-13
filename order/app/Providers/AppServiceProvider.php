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
            \App\Modules\Order\Domain\Api\CartApiInterface::class,
            \App\Modules\Order\Infrastructure\Grpc\CartGrpc::class
            // \App\Modules\Order\Infrastructure\Api\CartApi::class
        );

        $this->app->bind(
            \App\Modules\Order\Domain\Repositories\OrderRepositoryInterface::class,
            \App\Modules\Order\Infrastructure\Persistence\EloquentOrderRepository::class
        );

        $this->app->bind(
            \App\Modules\Order\Domain\Repositories\OrderQueryRepositoryInterface::class,
            \App\Modules\Order\Infrastructure\Persistence\EloquentOrderQueryRepository::class
        );

        $this->app->bind(
            \App\Modules\Shared\Application\Port\EventPublisherInterface::class,
            \App\Modules\Shared\Infrastructure\Persistence\OutboxEventPublisher::class
        );

        $this->app->bind(
            \App\Modules\Shared\Application\Port\MessagePublisherInterface::class,
            \App\Modules\Shared\Infrastructure\Messaging\RabbitMQEventPublisher::class
        );

        $this->app->bind(
            \App\Modules\Shared\Application\Port\OutboxRepositoryInterface::class,
            \App\Modules\Shared\Infrastructure\Persistence\EloquentOutboxRepository::class
        );
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
            } catch (\Exception $e) {
                // Log::error($e);
                return null;
            }
        });
    }
}
