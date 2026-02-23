<?php

namespace App\Modules\Payment\Infrastructure\Persistence\Doctrine;

use App\Modules\Payment\Application\Contracts\TransactionInterface;
use Doctrine\ORM\EntityManagerInterface;

final class DoctrineTransaction implements TransactionInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {}

    public function run(callable $callback): mixed
    {
        return $this->entityManager->wrapInTransaction(
            fn() => $callback()
        );
    }
}
