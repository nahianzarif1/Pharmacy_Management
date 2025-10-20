<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicineType extends Model
{
    use HasFactory;

    protected $table = 'medicine_types';

    protected $fillable = [
        'name',
        'description',
    ];

    public function medicines()
    {
        return $this->hasMany(Medicine::class);
    }
}
