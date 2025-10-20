<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = ['invoice_no','sold_by','customer_name','sale_date','subtotal','discount','tax','total','payment_method'];

    public function items()
    {
        return $this->hasMany(SaleItem::class);
    }
}
