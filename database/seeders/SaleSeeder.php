<?php

namespace Database\Seeders;

use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Medicine;
use App\Models\User;
use App\Models\InventoryBatch;
use Illuminate\Database\Seeder;

class SaleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::first();
        $medicines = Medicine::all();

        // Create a few sales
        for ($i = 1; $i <= 3; $i++) {
            $sale = Sale::create([
                'invoice_no' => 'SALE-' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'sold_by' => $user->id,
                'customer_name' => 'Walk-in Customer ' . $i,
                'sale_date' => now()->subDays(rand(0, 7)),
                'subtotal' => 0,
                'discount' => 0,
                'tax' => 0,
                'total' => 0,
                'payment_method' => 'cash',
            ]);

            $subtotal = 0;

            // Add 2-3 random medicines to each sale
            foreach ($medicines->random(rand(2, 3)) as $medicine) {
                // Get available batch
                $batch = InventoryBatch::where('medicine_id', $medicine->id)
                    ->where('quantity', '>', 0)
                    ->first();

                if ($batch) {
                    $quantity = rand(1, 5);
                    $unit_price = $medicine->price_per_unit; // Use medicine's price
                    $lineTotal = $quantity * $unit_price;
                    $subtotal += $lineTotal;

                    SaleItem::create([
                        'sale_id' => $sale->id,
                        'medicine_id' => $medicine->id,
                        'batch_id' => $batch->id,
                        'quantity' => $quantity,
                        'unit_price' => $unit_price,
                    ]);

                    // Update batch quantity
                    $batch->update([
                        'quantity' => $batch->quantity - $quantity
                    ]);
                }
            }

            $tax = $subtotal * 0.05; // 5% tax
            $total = $subtotal + $tax;

            // Update sale total
            $sale->update([
                'subtotal' => $subtotal,
                'tax' => $tax,
                'total' => $total,
            ]);
        }
    }
}
