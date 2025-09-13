<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'product_id',
        'order_id',
        'payment_id',
        'pay_currency',
        'price_amount',
        'price_currency',
        'payment_status',
        'invoice_url',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
