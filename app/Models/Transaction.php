<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $table = 'transactions';

    protected $fillable = [
        'transaction_type', // e.g., 'purchase', 'sale', 'return'
        'reference_id',     // foreign key to purchase/sale/return
        'amount',
        'payment_method',   // e.g., cash, card, mobile
        'transaction_date',
    ];
}
