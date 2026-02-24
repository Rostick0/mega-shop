<?php

namespace App\Modules\Order\Infrastructure\Eloquent;

use App\Modules\Order\Domain\Entity\OrderStatusEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EloquentOutboxMessage extends Model
{
    protected $table = 'outbox_messages';

    protected $fillable = [
        'id',
        'exchange',
        'routing_key',
        'payload',
        'status',
        // $table->enum('status', ['pending', 'sent', 'failed'])->default('pending');
        'attempts',
        'created_at',
        'sent_at',
        'error'
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [

            // 'status' => OrderStatusEnum::class,
        ];
    }
}
