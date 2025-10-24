<?php

namespace Database\Seeders;

use App\Models\Medicine;
use App\Models\MedicineType;
use Illuminate\Database\Seeder;

class MedicineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tabletTypeId = MedicineType::where('name', 'Tablet')->first()->id;
        $syrupTypeId = MedicineType::where('name', 'Syrup')->first()->id;
        $injectionTypeId = MedicineType::where('name', 'Injection')->first()->id;

        $medicines = [
            [
                'sku' => 'PCM500',
                'name' => 'Paracetamol',
                'generic_name' => 'Acetaminophen',
                'medicine_type_id' => $tabletTypeId,
                'unit' => 'tablet',
                'strength' => '500mg',
                'price_per_unit' => 2.50,
                'reorder_level' => 100,
                'is_active' => true,
            ],
            [
                'sku' => 'AMX500',
                'name' => 'Amoxicillin',
                'generic_name' => 'Amoxicillin',
                'medicine_type_id' => $tabletTypeId,
                'unit' => 'tablet',
                'strength' => '500mg',
                'price_per_unit' => 5.00,
                'reorder_level' => 50,
                'is_active' => true,
            ],
            [
                'sku' => 'CSY100',
                'name' => 'Cough Syrup',
                'generic_name' => 'Dextromethorphan',
                'medicine_type_id' => $syrupTypeId,
                'unit' => 'bottle',
                'strength' => '100ml',
                'price_per_unit' => 15.00,
                'reorder_level' => 30,
                'is_active' => true,
            ],
            [
                'sku' => 'VBC001',
                'name' => 'Vitamin B Complex',
                'generic_name' => 'Vitamin B Complex',
                'medicine_type_id' => $injectionTypeId,
                'unit' => 'ampule',
                'strength' => '2ml',
                'price_per_unit' => 8.00,
                'reorder_level' => 20,
                'is_active' => true,
            ],
        ];

        foreach ($medicines as $medicine) {
            Medicine::create($medicine);
        }
    }
}
