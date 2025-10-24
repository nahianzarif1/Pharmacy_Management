<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockMovement extends Model
{
    use HasFactory;

    public $timestamps = false; // created_at only
    protected $fillable = ['medicine_id','batch_id','change','movement_type','created_by','created_at'];

    protected $dates = ['created_at'];

    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }

    public function batch()
    {
        return $this->belongsTo(InventoryBatch::class, 'batch_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
