<?php

namespace Database\Seeders;

use App\Models\TourAddon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class TourAddonSeeder extends Seeder
{
    public function run(): void
    {
        if (!Schema::hasTable('extra_services')) {
            return;
        }

        foreach (TourAddon::defaultServices() as $idx => $item) {
            TourAddon::firstOrCreate(
                ['code' => $item['code']],
                [
                    'name' => $item['name'],
                    'description' => $item['description'],
                    'price' => $item['price'],
                    'price_unit' => $item['price_unit'],
                    'calculation_type' => $item['calculation_type'],
                    'sort_order' => $idx + 1,
                    'is_active' => true,
                ]
            );
        }
    }
}
