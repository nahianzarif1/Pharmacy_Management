<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed in order of dependencies
        $this->call([
            SettingSeeder::class,     // Basic settings first
            UserSeeder::class,        // Users needed for other operations
            MedicineTypeSeeder::class, // Types needed for medicines
            SupplierSeeder::class,    // Suppliers needed for purchases
            MedicineSeeder::class,    // Medicines needed for inventory and sales
            PurchaseSeeder::class,    // Purchases create inventory
            InventoryBatchSeeder::class, // Create inventory batches for medicines
            SaleSeeder::class,        // Sales depend on inventory
        ]);
    }
}
