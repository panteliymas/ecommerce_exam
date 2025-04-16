<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'photo',
    ];

    /**
     * Get the category's products.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products() : \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ProductToCategory::class, 'category_id', 'id');
    }
}
