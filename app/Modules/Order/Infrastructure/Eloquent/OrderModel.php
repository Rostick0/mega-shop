<?php

namespace App\Modules\Order\Infrastructure\Eloquent;

use App\Modules\Order\Domain\Entity\OrderItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OrderModel extends Model
{
    protected $table = 'orders';

    protected $fillable = [
        'title',
        'user_id',
        'email',
        'amount',
        'status',
    ];

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}
