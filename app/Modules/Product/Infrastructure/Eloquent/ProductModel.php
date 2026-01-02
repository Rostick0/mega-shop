<?php

namespace App\Modules\Product\Infrastructure\Eloquent;

use Illuminate\Database\Eloquent\Model;

class ProductModel extends Model
{
    protected $table = 'products';

    protected $fillable = [
        'title',
        'price',
        'rating',
    ];
}
