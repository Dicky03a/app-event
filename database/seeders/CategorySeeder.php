<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Periksa apakah kategori sudah ada untuk menghindari duplikasi
        if(\App\Models\Category::count() > 0) {
            return; // Jika sudah ada data, hentikan proses seeding
        }

        // Buat kategori default
        \App\Models\Category::create([
            'name' => 'Wisata Alam',
            'icon' => 'fa-tree',
            'slug' => 'wisata-alam',
        ]);

        \App\Models\Category::create([
            'name' => 'Wisata Buatan',
            'icon' => 'fa-building',
            'slug' => 'wisata-buatan',
        ]);

        \App\Models\Category::create([
            'name' => 'Wisata Sejarah',
            'icon' => 'fa-landmark',
            'slug' => 'wisata-sejarah',
        ]);

        \App\Models\Category::create([
            'name' => 'Wisata Kuliner',
            'icon' => 'fa-utensils',
            'slug' => 'wisata-kuliner',
        ]);
    }
}
