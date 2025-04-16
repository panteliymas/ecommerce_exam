<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductToCategory extends Model
{
    protected $fillable = [
        'product_id',
        'category_id',
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
