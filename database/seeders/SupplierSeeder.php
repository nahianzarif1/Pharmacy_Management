<?php

namespace Database\Seeders;

use App\Models\Supplier;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $suppliers = [
            [
                'name' => 'ABC Pharmaceuticals',
                'contact_name' => 'John Doe',
                'email' => 'contact@abcpharma.com',
                'phone' => '0123456789',
                'address' => '123 Pharma Street, Medical City',
            ],
            [
                'name' => 'MediSupply Co.',
                'contact_name' => 'Jane Smith',
                'email' => 'info@medisupply.com',
                'phone' => '0187654321',
                'address' => '456 Health Avenue, Care District',
            ],
            [
                'name' => 'Global Meds',
                'contact_name' => 'Bob Johnson',
                'email' => 'orders@globalmeds.com',
                'phone' => '0198765432',
                'address' => '789 Medicine Road, Pharmacy Zone',
            ],
        ];

        foreach ($suppliers as $supplier) {
            Supplier::create($supplier);
        }
    }
}
