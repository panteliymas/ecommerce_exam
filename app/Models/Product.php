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
        return $this->belongsToMany(Category::class, 'products_to_categories');
    }

    public function scopeWithFilters($query, $filters = [])
    {
        $categories = $filters['categories'] ?? [];
        $min_price = $filters['min_price'] ?? 0;
        $max_price = $filters['max_price'] ?? 0;
        return $query->when(count($categories), function ($query) use ($categories) {
                $query->whereHas('categories', function ($query) use ($categories) {
                    $query->whereIn('categories.id', $categories);
                });
            })
            ->when($min_price > 0, function ($query) use ($min_price) {
                $query->where('price', '>', $min_price);
            })
            ->when($max_price > 0, function ($query) use ($max_price) {
                $query->where('price', '<', $max_price);
            });
    }
}
