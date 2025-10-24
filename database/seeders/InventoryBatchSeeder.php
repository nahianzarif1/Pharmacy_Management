<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\InventoryBatch;
use App\Models\Medicine;
use Illuminate\Support\Str;

class InventoryBatchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $medicines = Medicine::all();

        if ($medicines->isEmpty()) {
            return;
        }

        foreach ($medicines as $medicine) {
            // create 1-3 batches per medicine
            $batches = rand(1,3);
            for ($i = 0; $i < $batches; $i++) {
                InventoryBatch::create([
                    'medicine_id' => $medicine->id,
                    'batch_no' => strtoupper(Str::random(6)),
                    'quantity' => rand(50, 500),
                    'received_date' => now()->subDays(rand(1, 180)),
                    'expiry_date' => now()->addMonths(rand(6,36)),
                    'unit_cost' => $medicine->price_per_unit * (0.7 + rand(0,30)/100),
                    'is_active' => true,
                ]);
            }
        }
    }
}
