<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'total',
        'delivery',
        'status'
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'products_to_orders')
            ->withPivot('quantity')
            ->withTimestamps();
    }
}
