<?php

namespace Database\Seeders;

use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\Medicine;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Database\Seeder;

class PurchaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $supplier = Supplier::first();
        $user = User::first();
        $medicines = Medicine::all();

        // Create a purchase
        $purchase = Purchase::create([
            'supplier_id' => $supplier->id,
            'invoice_no' => 'INV-001',
            'purchase_date' => now(),
            'total_amount' => 0,
            'created_by' => $user->id,
        ]);

        $totalAmount = 0;

        // Add items to the purchase
        foreach ($medicines as $medicine) {
            $quantity = rand(50, 100);
            $unit_price = $medicine->price_per_unit * 0.8; // 20% margin
            $subtotal = $quantity * $unit_price;
            $totalAmount += $subtotal;

            PurchaseItem::create([
                'purchase_id' => $purchase->id,
                'medicine_id' => $medicine->id,
                'quantity' => $quantity,
                'unit_cost' => $unit_price,
                'batch_no' => 'B' . str_pad(rand(1, 999), 3, '0', STR_PAD_LEFT),
            ]);
        }

        // Update purchase total
        $purchase->update([
            'total_amount' => $totalAmount,
        ]);
    }
}
