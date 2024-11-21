<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BasketProduct extends Model
{
    use HasFactory;

    protected $fillable = ['basket_id', 'product_id', 'stock_count'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function basket()
    {
        return $this->belongsTo(Basket::class);
    }
}
