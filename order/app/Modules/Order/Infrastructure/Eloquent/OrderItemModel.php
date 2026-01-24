<?php

namespace App\Modules\Order\Infrastructure\Eloquent;

use App\Modules\Order\Domain\Entity\Order;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItemModel extends Model
{
    protected $table = 'order_items';

    protected $fillable = [
        'title',
        'user_id',
        'email',
        'amount',
        'status',
        // items,
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
