<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    public const COURIER_PRICES = [
        'JNE' => 15000,
        'TIKI' => 14000,
        'POS Indonesia' => 12000,
        'SiCepat' => 16000,
        'J&T Express' => 15500,
    ];

    protected $fillable = [
        'user_id',
        'order_number',
        'total_amount',
        'status',
        'shipping_address',
        'shipping_phone',
        'notes',
        'courier',
        'subtotal',
        'discount_amount',
        'shipping_cost',
        'coupon_code',
    ];

    public function getCourierPrice(): float
    {
        return self::COURIER_PRICES[$this->courier] ?? 0;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class)
            ->withPivot('quantity', 'price')
            ->withTimestamps();
    }
}
