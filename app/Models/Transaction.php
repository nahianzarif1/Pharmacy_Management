<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $table = 'transactions';

    protected $fillable = [
        'sale_id',
        'return_id',
        'purchase_id',
        'payment_method',
        'amount',
        'transaction_date',
        'created_by',
    ];
}
