<?php

namespace Database\Seeders;

use App\Models\Artikel;
use App\Models\Berita;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class HomepageDummySeeder extends Seeder
{
    public function run(): void
    {
        $reporter  = User::where('email', 'reporter@test.local')->first();
        $fotograf  = User::where('email', 'fotographer@test.local')->first();
        $copy      = User::where('email', 'copywriting@test.local')->first();
        $ilustra   = User::where('email', 'illustrator@test.local')->first();
        $pk        = User::where('email', 'perencanaan_konten@test.local')->first();

        if (!$pk || !$reporter) {
            $this->command->warn('User testing belum ada. Jalankan DatabaseSeeder dulu.');
            return;
        }

        $katBerita  = Category::where('type', 'berita')->get();
        $katArtikel = Category::where('type', 'artikel')->get();

        $judulBerita = [
            'ENT GEN 21 Gelar Pelatihan Lintas Divisi Selama Tiga Hari',
            'Tim Videographer ENT Raih Juara 2 Kompetisi Film Pendek Nasional',
            'Pendaftaran Anggota Baru ENT Dibuka, Kuota Terbatas 50 Orang',
            'Workshop Jurnalistik: Dari Naskah Hingga Terbit di Portal Berita',
            'Kolaborasi Divisi Desain Grafis dan Illustrator Lahirkan Identitas Baru',
            'ENT Adakan Bakti Sosial di Panti Asuhan, Kumpulkan 200 Buku Layak Baca',
            'Mahasiswa ENT Lolos Seleksi Pertukaran Pelajar ke Jepang',
            'Rapat Kerja Tahunan: ENT Targetkan 12 Program Unggulan Tahun Ini',
            'Peluncuran Portal Berita Baru ENT, Lebih Cepat dan Interaktif',
            'Divisi Reporter Liput Langsung Festival Budaya Kampus',
            'ENT dan UKM Fotografi Adakan Pameran Karya Bersama',
            'Kunjungan Industri ke Kantor Media Nasional Perkaya Wawasan Anggota',
        ];

        $judulArtikel = [
            'Opini: Mengapa Media Kampus Penting untuk Ekosistem Jurnalisme',
            '5 Tips Menulis Berita yang Menarik bagi Pemula',
            'Mengenal Lebih Dekat Divisi Videographer ENT GEN 21',
            'Panduan Fotografi Berita: Komposisi yang Bercerita',
            'Opini: Tantangan Media Kampus di Era Algoritma Media Sosial',
            'Checklist Produksi Konten dari Perencanaan hingga Publikasi',
            'Profil: Di Balik Layar Tim Redaksi Portal Berita ENT',
            'Cara Menulis Headline yang Kuat Tanpa Clickbait',
            'Ilustrasi Editorial: Menjembatani Teks dan Visual',
        ];

        $penulisBerita = [
            [$reporter->id => ['role_in_content' => 'reporter']],
            [$reporter->id => ['role_in_content' => 'reporter'], $fotograf->id => ['role_in_content' => 'fotografer']],
            [$copy->id => ['role_in_content' => 'penulis']],
            [$fotograf->id => ['role_in_content' => 'fotografer'], $copy->id => ['role_in_content' => 'penulis']],
        ];

        foreach ($judulBerita as $i => $judul) {
            $berita = Berita::firstOrCreate(
                ['slug' => Str::slug($judul)],
                [
                    'category_id'  => $katBerita->isNotEmpty() ? $katBerita[$i % $katBerita->count()]->id : null,
                    'created_by'   => $pk->id,
                    'title'        => $judul,
                    'excerpt'      => 'Ringkasan singkat berita ini memberikan gambaran awal mengenai peristiwa yang diliput oleh tim ENT GEN 21.',
                    'content'      => '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Kegiatan ini diikuti oleh puluhan anggota dari berbagai divisi.</p><p>Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Antusiasme peserta terlihat sejak sesi pertama dibuka.</p><p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>',
                    'status'       => 'published',
                    'published_at' => now()->subHours(($i + 1) * 5),
                ]
            );

            if ($berita->penulis()->doesntExist()) {
                $berita->penulis()->attach($penulisBerita[$i % count($penulisBerita)]);
            }
        }

        $penulisArtikel = [
            [$ilustra->id => ['role_in_content' => 'penulis']],
            [$copy->id => ['role_in_content' => 'penulis']],
            [$reporter->id => ['role_in_content' => 'penulis']],
        ];

        foreach ($judulArtikel as $i => $judul) {
            $artikel = Artikel::firstOrCreate(
                ['slug' => Str::slug($judul)],
                [
                    'category_id'  => $katArtikel->isNotEmpty() ? $katArtikel[$i % $katArtikel->count()]->id : null,
                    'created_by'   => $pk->id,
                    'title'        => $judul,
                    'excerpt'      => 'Artikel ini membahas topik secara mendalam dengan sudut pandang redaksi ENT GEN 21.',
                    'content'      => '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Dalam artikel ini kita akan membahas topik tersebut secara bertahap.</p><p>Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Setiap bagian dilengkapi contoh praktis yang mudah diikuti.</p><p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>',
                    'status'       => 'published',
                    'published_at' => now()->subHours(($i + 1) * 7),
                ]
            );

            if ($artikel->penulis()->doesntExist()) {
                $artikel->penulis()->attach($penulisArtikel[$i % count($penulisArtikel)]);
            }
        }

        $this->command->info('HomepageDummySeeder: 12 berita & 9 artikel dummy siap.');
    }
}
