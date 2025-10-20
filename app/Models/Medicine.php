<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    use HasFactory;

    protected $fillable = [
        'sku','name','generic_name','medicine_type_id','unit','strength','price_per_unit','reorder_level','is_active'
    ];

    public function type()
    {
        return $this->belongsTo(MedicineType::class, 'medicine_type_id');
    }

    public function batches()
    {
        return $this->hasMany(InventoryBatch::class);
    }

    public function purchaseItems()
    {
        return $this->hasMany(PurchaseItem::class);
    }

    public function saleItems()
    {
        return $this->hasMany(SaleItem::class);
    }
}
