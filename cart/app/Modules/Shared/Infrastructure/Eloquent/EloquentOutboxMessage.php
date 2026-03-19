<?php

namespace App\Modules\Shared\Infrastructure\Eloquent;

use Illuminate\Database\Eloquent\Model;

class EloquentOutboxMessage extends Model
{
    protected $table = 'outbox_messages';

    protected $keyType = 'string';
    public $incrementing = false;

    public $timestamps = false;

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
