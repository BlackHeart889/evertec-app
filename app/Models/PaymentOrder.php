<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'request_id',
        'process_url',
        'status',
        'created_at',
        'updated_at',
    ];
}
