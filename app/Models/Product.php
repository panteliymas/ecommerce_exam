<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'label',
        'photo',
        'price',
        'status',
        'stock'
    ];

    /**
     * Get the product's categories.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories() : \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongToMany(ProductToCategory::class, 'product_id', 'id');
    }
}
