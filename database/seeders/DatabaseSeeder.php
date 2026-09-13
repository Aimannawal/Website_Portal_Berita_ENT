<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            DivisionSeeder::class,   // 1. divisi dulu (dibutuhkan oleh users)
            RoleSeeder::class,       // 2. role + permission (Spatie)
            CategorySeeder::class,   // 3. kategori
            UserSeeder::class,       // 4. user testing per role
            ContentTestSeeder::class,// 5. sample berita/artikel/task
        ]);
    }
}
