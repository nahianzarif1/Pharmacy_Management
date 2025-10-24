<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            [
                'key' => 'pharmacy_name',
                'value' => 'My Pharmacy',
            ],
            [
                'key' => 'pharmacy_address',
                'value' => '123 Health Street, Medical City',
            ],
            [
                'key' => 'pharmacy_phone',
                'value' => '01234567890',
            ],
            [
                'key' => 'pharmacy_email',
                'value' => 'contact@mypharmacy.com',
            ],
            [
                'key' => 'low_stock_threshold',
                'value' => '20',
            ],
            [
                'key' => 'default_tax_rate',
                'value' => '5',
            ],
        ];

        foreach ($settings as $setting) {
            Setting::create($setting);
        }
    }
}
