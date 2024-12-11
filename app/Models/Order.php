<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'basket_id',
        'quantity',
        'uid',
        'status',
        'address',
        'payment_type',
        'shipping_adress_id', // Make sure this is consistent with the migration
        'total',
    ];
    public static function getStatuses()
    {
        return [
            0 => 'Pending',
            1 => 'Processing',
            2 => 'Shipped',
            3 => 'Delivered',
            4 => 'Cancelled',
        ];
    }

    public function getStatusTextAttribute()
    {
        return self::getStatuses()[$this->status] ?? 'Unknown';
    }


    public function details()
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function shippingMethod()
    {
        return $this->belongsTo(ShippingAddress::class, 'shipping_adress_id'); // Ensure the column name matches
    }
}
