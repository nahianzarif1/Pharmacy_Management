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

    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }
}
