<?php

use App\Grpc\Cart\CartServiceInterface;
use App\Modules\Cart\Infrastructure\Adapter\CartOwnerResolver;
use App\Modules\Cart\Infrastructure\Repository\CacheCartRepository;
use App\Modules\Cart\Presentation\Grpc\Controllers\CartController;
use App\Modules\Order\Domain\Api\CartApiInterface;
use Spiral\RoadRunner\GRPC\Server;
use Spiral\Goridge\StreamRelay;
use Spiral\Goridge\RPC\RPC;

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

// Не запускайте HTTP kernel! Только Console для доступа к контейнеру
$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$server = new Server();
// $cartController = new CartController(
//     app(CacheCartRepository::class),
//     app(CartOwnerResolver::class)
// );

$cartController = app(CartController::class);
$server->registerService(CartServiceInterface::class, $cartController);

$server->serve();
    // StreamRelay::create('pipes')