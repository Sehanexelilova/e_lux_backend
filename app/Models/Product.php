<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ProductsDescription;


class Product extends Model
{
    protected $fillable = [
        'category_id',
        'product_name',
        'product_code',
        'product_color',
        'image',
        'other_photos',
        'family_color',
        'product_size',
        'group_code',
        'product_price',
        'product_discount',
        'free_shipping',
        'free_changes_return',
        'description',
        'wash_care',
        'fabric',
        'pattern',
        'meta_title',
        'meta_keyword',
        'meta_description',

    ];

    protected $casts = [
        'product_color' => 'array',
        'product_size' => 'array',
        'other_photos' => 'array',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function productsDescription()
    {
        return $this->hasOne(ProductsDescription::class);
    }
}
