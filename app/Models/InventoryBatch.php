<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryBatch extends Model
{
    use HasFactory;

    protected $fillable = [
        'medicine_id','batch_no','quantity','received_date','expiry_date','unit_cost','is_active'
    ];

    protected $casts = [
        'quantity' => 'integer',
        'received_date' => 'date',
        'expiry_date' => 'date',
        'unit_cost' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }

    public function scopeExpiringSoon($query, $months = 3)
    {
        return $query->whereNotNull('expiry_date')
            ->where('expiry_date', '<=', now()->addMonths($months));
    }

    public function movements()
    {
        return $this->hasMany(StockMovement::class, 'batch_id');
    }
}
