<?php

namespace Database\Seeders;

use App\Models\Division;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DivisionSeeder extends Seeder
{
    public static array $divisions = [
        'Webmaster',
        'Perencanaan Konten',
        'Fotographer',
        'Videographer',
        'Copywriting',
        'Illustrator',
        'Reporter',
        'Desain Grafis',
    ];

    public function run(): void
    {
        foreach (self::$divisions as $name) {
            Division::firstOrCreate(
                ['slug' => Str::slug($name)],
                ['name' => $name]
            );
        }
    }
}
