<?php

namespace Database\Seeders;

use App\Models\Artikel;
use App\Models\Berita;
use App\Models\Category;
use App\Models\Division;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ContentTestSeeder extends Seeder
{
    public function run(): void
    {
        $pk       = User::where('email', 'perencanaan_konten@test.local')->first();
        $reporter = User::where('email', 'reporter@test.local')->first();
        $fotograf = User::where('email', 'fotographer@test.local')->first();
        $ilustra  = User::where('email', 'illustrator@test.local')->first();
        $categoryBerita = Category::where('type', 'berita')->first();
        $categoryArtikel = Category::where('type', 'artikel')->first();
        $divVideo = Division::where('slug', 'videographer')->first();

        // ---- Contoh Berita, ditulis 2 orang (reporter + fotografer) ----
        $berita = Berita::create([
            'category_id' => $categoryBerita?->id,
            'created_by'  => $pk->id,
            'title'       => 'Contoh Berita: Kegiatan Pelatihan Divisi ENT GEN 21',
            'slug'        => Str::slug('Contoh Berita Kegiatan Pelatihan Divisi ENT GEN 21') . '-' . Str::random(5),
            'excerpt'     => 'Ringkasan singkat kegiatan pelatihan lintas divisi.',
            'content'     => '<p>Isi lengkap berita hasil dari rich text editor akan tampil di sini...</p>',
            'thumbnail'   => null,
            'status'      => 'published',
            'published_at'=> now(),
        ]);

        $berita->penulis()->attach([
            $reporter->id => ['role_in_content' => 'reporter'],
            $fotograf->id => ['role_in_content' => 'fotografer'],
        ]);

        // contoh multiple image utk 1 berita (path dummy, sesuaikan dgn hasil upload asli)
        $berita->images()->createMany([
            ['file_path' => 'berita/contoh-1.jpg', 'original_name' => 'contoh-1.jpg', 'order' => 0],
            ['file_path' => 'berita/contoh-2.jpg', 'original_name' => 'contoh-2.jpg', 'order' => 1],
            ['file_path' => 'berita/contoh-3.jpg', 'original_name' => 'contoh-3.jpg', 'order' => 2],
        ]);

        // ---- Contoh Artikel, ditulis 1 orang (illustrator) ----
        $artikel = Artikel::create([
            'category_id' => $categoryArtikel?->id,
            'created_by'  => $pk->id,
            'title'       => 'Contoh Artikel: Tips Membuat Ilustrasi untuk Portal Berita',
            'slug'        => Str::slug('Contoh Artikel Tips Membuat Ilustrasi untuk Portal Berita') . '-' . Str::random(5),
            'excerpt'     => 'Beberapa tips singkat seputar ilustrasi digital.',
            'content'     => '<p>Isi lengkap artikel...</p>',
            'status'      => 'draft',
        ]);

        $artikel->penulis()->attach([
            $ilustra->id => ['role_in_content' => 'illustrator'],
        ]);

        $artikel->images()->create([
            'file_path' => 'artikel/cover-1.jpg', 'original_name' => 'cover-1.jpg', 'order' => 0,
        ]);

        // ---- Contoh Task: PK assign ke divisi Videographer terkait berita di atas ----
        Task::create([
            'title'                => 'Buat liputan video pendukung berita pelatihan',
            'description'          => 'Ambil footage kegiatan dan buat video singkat 1-2 menit.',
            'assigned_by'          => $pk->id,
            'assigned_to_division' => $divVideo?->id,
            'berita_id'            => $berita->id,
            'status'               => 'pending',
            'deadline'             => now()->addDays(5),
        ]);
    }
}
