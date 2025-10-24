<?php

namespace Database\Seeders;

use App\Models\MedicineType;
use Illuminate\Database\Seeder;

class MedicineTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            ['name' => 'Tablet', 'description' => 'Oral solid dose forms'],
            ['name' => 'Capsule', 'description' => 'Oral solid dose forms in capsule'],
            ['name' => 'Syrup', 'description' => 'Oral liquid medications'],
            ['name' => 'Injection', 'description' => 'Injectable medications'],
            ['name' => 'Cream', 'description' => 'Topical medications'],
            ['name' => 'Ointment', 'description' => 'Topical medications'],
            ['name' => 'Drop', 'description' => 'Eye/Ear drops'],
            ['name' => 'Inhaler', 'description' => 'Respiratory medications'],
        ];

        foreach ($types as $type) {
            MedicineType::create($type);
        }
    }
}
