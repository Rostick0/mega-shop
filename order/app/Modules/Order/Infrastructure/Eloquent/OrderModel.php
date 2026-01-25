<?php

namespace App\Modules\Order\Infrastructure\Eloquent;

use App\Modules\Order\Domain\Entity\OrderStatusEnum;
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

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'status' => OrderStatusEnum::class,
        ];
    }

    public function ordergetItems(): HasMany
    {
        return $this->hasMany(OrderItemModel::class, 'order_id', 'id');
    }
}
