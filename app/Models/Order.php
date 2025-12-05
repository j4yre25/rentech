<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'order_number',
        'order_date',
        'customer_name',
        'payment_status',
        'order_status',
        'total',
    ];
}