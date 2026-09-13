<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Kegiatan Kampus', 'type' => 'berita'],
            ['name' => 'Prestasi Mahasiswa', 'type' => 'berita'],
            ['name' => 'Pengumuman', 'type' => 'berita'],
            ['name' => 'Opini', 'type' => 'artikel'],
            ['name' => 'Tutorial & Tips', 'type' => 'artikel'],
            ['name' => 'Profil Divisi', 'type' => 'artikel'],
        ];

        foreach ($categories as $item) {
            Category::firstOrCreate(
                ['slug' => Str::slug($item['name'])],
                ['name' => $item['name'], 'type' => $item['type']]
            );
        }
    }
}
