<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'name',
        'slug',
        'description',
        'photo',
    ];

    /**
     * Get the category's products.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function products() : \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'products_to_categories');
    }
}
