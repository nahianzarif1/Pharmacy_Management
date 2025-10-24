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

    protected $casts = [
        'price_per_unit' => 'decimal:2',
        'reorder_level' => 'integer',
        'is_active' => 'boolean',
    ];

    // existing relation kept for backward compat
    public function type()
    {
        return $this->belongsTo(MedicineType::class, 'medicine_type_id');
    }

    // alias used by controllers/views: medicineType
    public function medicineType()
    {
        return $this->type();
    }

    public function batches()
    {
        return $this->hasMany(InventoryBatch::class);
    }

    // alias used in controllers/views: inventoryBatches
    public function inventoryBatches()
    {
        return $this->batches();
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeLowStock($query)
    {
        // This scope identifies medicines whose total batch qty <= reorder_level
        return $query->whereRaw('(
            select coalesce(sum(quantity),0) from inventory_batches where inventory_batches.medicine_id = medicines.id
        ) <= medicines.reorder_level');
    }

    public function purchaseItems()
    {
        return $this->hasMany(PurchaseItem::class);
    }

    public function saleItems()
    {
        return $this->hasMany(SaleItem::class);
    }

    /**
     * Stock movements for this medicine (purchases/sales/adjustments)
     */
    public function stockMovements()
    {
        return $this->hasMany(StockMovement::class);
    }
}
