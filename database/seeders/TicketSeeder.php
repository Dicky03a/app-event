<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Ticket;
use App\Models\Category;

class TicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Periksa apakah ticket sudah ada untuk menghindari duplikasi
        if(\App\Models\Ticket::count() > 0) {
            return; // Jika sudah ada data, hentikan proses seeding
        }

        // Pastikan kategori tersedia
        $category = \App\Models\Category::first();
        if (!$category) {
            $this->call(CategorySeeder::class);
            $category = \App\Models\Category::first();
        }

        // Buat ticket default
        \App\Models\Ticket::create([
            'name' => 'Taman Nasional Bromo Tengger Semeru',
            'slug' => 'taman-nasional-bromo-tengger-semeru',
            'address' => 'Malang, Jawa Timur',
            'thumbnail' => null,
            'path_video' => 'https://www.youtube.com/embed/sample_video',
            'price' => 275000,
            'is_popular' => true,
            'about' => 'Taman Nasional Bromo Tengger Semeru merupakan salah satu destinasi wisata alam terpopuler di Indonesia dengan pemandangan gunung berapi yang menakjubkan.',
            'open_time_at' => '06:00',
            'close_time_at' => '18:00',
            'category_id' => $category->id,
            'approval_status' => 'approved',
            'approval_notes' => null,
        ]);
    }
}
