<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'order_id',
        'name',
        'email',
        'card_number',
        'card_exp_month',
        'card_exp_year',
        'subscription',
        'subscription_id',
        'price',
        'price_currency',
        'txn_id',
        'payment_status',
        'receipt',
        'payment_type',
        'payment_status',
        'user_id',
    ];


}
