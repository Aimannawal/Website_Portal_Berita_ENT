<?php

namespace Tests\Feature;

use App\Models\Artikel;
use App\Models\Berita;
use App\Models\Category;
use App\Models\Subscriber;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class PublicPortalTest extends TestCase
{
    use RefreshDatabase;

    private User $penulis;

    protected function setUp(): void
    {
        parent::setUp();
        $this->penulis = User::factory()->create();
    }

    private function buatBerita(array $attrs = []): Berita
    {
        $judul = $attrs['title'] ?? 'Berita Uji ' . Str::random(6);

        return Berita::create(array_merge([
            'created_by' => $this->penulis->id,
            'title' => $judul,
            'slug' => Str::slug($judul) . '-' . Str::random(5),
            'excerpt' => 'Ringkasan berita uji.',
            'content' => '<p>Isi berita uji.</p>',
            'status' => 'published',
            'published_at' => now(),
        ], $attrs, ['slug' => Str::slug($judul) . '-' . Str::random(5)]));
    }

    private function buatArtikel(array $attrs = []): Artikel
    {
        $judul = $attrs['title'] ?? 'Artikel Uji ' . Str::random(6);

        return Artikel::create(array_merge([
            'created_by' => $this->penulis->id,
            'title' => $judul,
            'slug' => Str::slug($judul) . '-' . Str::random(5),
            'excerpt' => 'Ringkasan artikel uji.',
            'content' => '<p>Isi artikel uji.</p>',
            'status' => 'published',
            'published_at' => now(),
        ], $attrs, ['slug' => Str::slug($judul) . '-' . Str::random(5)]));
    }

    public function test_homepage_menampilkan_konten_terbit(): void
    {
        $this->buatBerita(['title' => 'Berita Terbit Pertama']);
        $this->buatArtikel(['title' => 'Artikel Terbit Pertama']);

        $this->get(route('public.index'))
            ->assertOk()
            ->assertSee('Berita Terbit Pertama')
            ->assertSee('Artikel Terbit Pertama');
    }

    public function test_pencarian_memfilter_berdasarkan_judul(): void
    {
        $this->buatBerita(['title' => 'Festival Budaya Kampus Meriah']);
        $this->buatBerita(['title' => 'Pelatihan Jurnalistik Dasar']);

        $response = $this->get(route('public.index', ['q' => 'Festival']));

        $response->assertOk()
            ->assertSee('Festival Budaya Kampus Meriah')
            ->assertSee('Hasil pencarian');
    }

    public function test_pencarian_tanpa_hasil_menampilkan_empty_state(): void
    {
        $this->buatBerita();

        $this->get(route('public.index', ['q' => 'katakunciyangmustahil123']))
            ->assertOk()
            ->assertSee('Tidak ada berita yang cocok');
    }

    public function test_filter_kategori_bekerja(): void
    {
        $kategori = Category::create(['name' => 'Teknologi', 'slug' => 'teknologi', 'type' => 'berita']);
        $this->buatBerita(['title' => 'Berita Teknologi Terkini', 'category_id' => $kategori->id]);
        $this->buatBerita(['title' => 'Berita Umum Lainnya']);

        $this->get(route('public.index', ['kategori' => 'teknologi']))
            ->assertOk()
            ->assertSee('Berita Teknologi Terkini');
    }

    public function test_detail_berita_tampil_dan_menambah_tayangan(): void
    {
        $berita = $this->buatBerita();

        $this->get(route('public.berita.show', $berita->slug))
            ->assertOk()
            ->assertSee($berita->title)
            ->assertSee('Berita Terkait');

        $this->assertSame(1, $berita->fresh()->views);

        // Kunjungan ulang dalam sesi yang sama tidak menambah tayangan
        $this->get(route('public.berita.show', $berita->slug))->assertOk();
        $this->assertSame(1, $berita->fresh()->views);
    }

    public function test_berita_draft_tidak_bisa_diakses_publik(): void
    {
        $berita = $this->buatBerita(['status' => 'draft']);

        $this->get(route('public.berita.show', $berita->slug))->assertNotFound();
    }

    public function test_subscribe_menyimpan_email_pelanggan(): void
    {
        $this->post(route('public.subscribe'), ['email' => 'pelanggan@example.com'])
            ->assertSessionHasNoErrors();

        $this->assertDatabaseHas('subscribers', ['email' => 'pelanggan@example.com']);
    }

    public function test_subscribe_menolak_email_duplikat_dan_tidak_valid(): void
    {
        Subscriber::create(['email' => 'sudah@ada.com']);

        $this->post(route('public.subscribe'), ['email' => 'sudah@ada.com'])
            ->assertSessionHasErrors('email');

        $this->post(route('public.subscribe'), ['email' => 'bukan-email'])
            ->assertSessionHasErrors('email');
    }

    public function test_halaman_statis_tampil_dan_slug_ngawur_404(): void
    {
        $this->get(route('public.page', 'tentang-kami'))
            ->assertOk()
            ->assertSee('Tentang Kami');

        $this->get(route('public.page', 'halaman-ngawur'))
            ->assertNotFound()
            ->assertSee('Halaman tidak ditemukan');
    }

    public function test_sitemap_dan_rss_feed_dapat_diakses(): void
    {
        $berita = $this->buatBerita();

        $this->get('/sitemap.xml')
            ->assertOk()
            ->assertHeader('Content-Type', 'application/xml')
            ->assertSee(route('public.berita.show', $berita->slug));

        $this->get('/feed')
            ->assertOk()
            ->assertHeader('Content-Type', 'application/rss+xml')
            ->assertSee($berita->title);
    }

    public function test_detail_artikel_tampil(): void
    {
        $artikel = $this->buatArtikel();

        $this->get(route('public.artikel.show', $artikel->slug))
            ->assertOk()
            ->assertSee($artikel->title)
            ->assertSee('Artikel Terkait');
    }
}
