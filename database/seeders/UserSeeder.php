<?php

namespace Database\Seeders;

use App\Models\Division;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    // role => nama divisi terkait (dipakai buat cari Division berdasarkan slug)
    public static array $roleDivisionMap = [
        'webmaster'          => 'Webmaster',
        'perencanaan_konten' => 'Perencanaan Konten',
        'fotographer'        => 'Fotographer',
        'videographer'       => 'Videographer',
        'copywriting'        => 'Copywriting',
        'illustrator'        => 'Illustrator',
        'reporter'           => 'Reporter',
        'desain_grafis'      => 'Desain Grafis',
    ];

    public function run(): void
    {
        foreach (self::$roleDivisionMap as $role => $divisionName) {
            $division = Division::where('slug', Str::slug($divisionName))->first();

            $user = User::firstOrCreate(
                ['email' => $role . '@test.local'],
                [
                    'name'         => ucwords(str_replace('_', ' ', $role)) . ' Test',
                    'password'     => Hash::make('password'), // password testing SEMUA: "password"
                    'division_id'  => $division?->id,
                    'email_verified_at' => now(),
                ]
            );

            // pastikan role tersinkron meski user sudah ada sebelumnya
            $user->syncRoles([$role]);
        }
    }
}
