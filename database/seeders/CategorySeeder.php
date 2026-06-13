<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Seni Lukis',
            'Seni Patung',
            'Seni Fotografi',
            'Seni Musik',
            'Seni Tari',
            'Seni Teater',
            'Kerajinan Tangan',
            'Desain Grafis',
        ];

        foreach ($categories as $name) {
            Category::firstOrCreate(['name' => $name]);
        }
    }
}
