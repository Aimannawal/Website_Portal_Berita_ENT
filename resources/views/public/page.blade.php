@extends('layouts.public')
@section('title', $title . ' — NewsHub')

@section('content')
<nav class="mb-6 flex items-center gap-2 text-xs text-slate-500" aria-label="Breadcrumb">
    <a href="{{ route('public.index') }}" class="transition hover:text-red-600">Beranda</a>
    <span>&rsaquo;</span>
    <span class="font-medium text-slate-700">{{ $title }}</span>
</nav>

<div class="mx-auto max-w-3xl">
    <h1 class="text-3xl font-extrabold tracking-tight text-slate-900 sm:text-4xl">{{ $title }}</h1>

    <div class="rich-content mt-6">
        @switch($slug)
            @case('tentang-kami')
                <p><strong>NewsHub</strong> adalah portal berita resmi yang dikelola oleh ENT GEN 21 — unit kegiatan mahasiswa yang bergerak di bidang media dan jurnalistik kampus.</p>
                <p>Kami hadir untuk menyajikan kabar terkini seputar kegiatan kampus, prestasi mahasiswa, serta artikel opini dan tutorial yang ditulis langsung oleh anggota redaksi dari berbagai divisi: reporter, fotografer, videografer, copywriting, ilustrator, dan desain grafis.</p>
                <h2>Visi</h2>
                <p>Menjadi media kampus yang kredibel, cepat, dan relevan bagi seluruh sivitas akademika.</p>
                <h2>Misi</h2>
                <ul>
                    <li>Menyajikan berita yang akurat dan berimbang.</li>
                    <li>Menjadi wadah pengembangan kemampuan jurnalistik mahasiswa.</li>
                    <li>Mendokumentasikan kegiatan dan prestasi sivitas akademika.</li>
                </ul>
                @break

            @case('karier')
                <p>Tertarik bergabung dengan tim redaksi NewsHub? Kami membuka kesempatan bagi mahasiswa aktif untuk berkembang bersama kami.</p>
                <h2>Posisi yang tersedia</h2>
                <ul>
                    <li><strong>Reporter</strong> — meliput dan menulis berita kegiatan kampus.</li>
                    <li><strong>Fotografer / Videografer</strong> — mendokumentasikan acara secara visual.</li>
                    <li><strong>Copywriter</strong> — menulis naskah artikel dan konten kreatif.</li>
                    <li><strong>Ilustrator / Desainer Grafis</strong> — membuat visual pendukung konten.</li>
                </ul>
                <h2>Cara mendaftar</h2>
                <p>Ikuti informasi open recruitment yang kami umumkan di halaman <a href="{{ route('public.index') }}">beranda</a>, atau hubungi kami melalui halaman <a href="{{ route('public.page', 'kontak') }}">kontak</a>.</p>
                @break

            @case('media-kit')
                <p>Halaman ini menyediakan aset resmi NewsHub untuk keperluan publikasi dan kerja sama media.</p>
                <h2>Identitas merek</h2>
                <ul>
                    <li>Nama: <strong>NewsHub — Portal Berita ENT GEN 21</strong></li>
                    <li>Warna utama: merah (#DC2626) dan slate gelap (#0F172A)</li>
                    <li>Font: Inter</li>
                </ul>
                <h2>Kerja sama media</h2>
                <p>Untuk pemasangan iklan, liputan khusus, atau kerja sama konten, silakan hubungi tim kami melalui halaman <a href="{{ route('public.page', 'kontak') }}">kontak</a>.</p>
                @break

            @case('kontak')
                <p>Punya pertanyaan, masukan, atau ingin mengirim rilis pers? Hubungi kami melalui salah satu kanal berikut:</p>
                <ul>
                    <li><strong>Email redaksi:</strong> redaksi@news.luthfihalimi.my.id</li>
                    <li><strong>Sekretariat:</strong> Ruang ENT GEN 21, Kampus</li>
                    <li><strong>Jam layanan:</strong> Senin–Jumat, 09.00–16.00 WIB</li>
                </ul>
                <p>Kami berusaha membalas setiap pesan dalam 1–2 hari kerja.</p>
                @break

            @case('faq')
                <h2>Pertanyaan yang sering diajukan</h2>
                <p><strong>Bagaimana cara berlangganan NewsHub?</strong><br>
                Masukkan alamat email Anda pada kolom "Berlangganan" di bagian bawah halaman, lalu klik tombol Langganan.</p>
                <p><strong>Apakah saya bisa mengirim tulisan?</strong><br>
                Bisa. Mahasiswa aktif dapat mengirim naskah melalui email redaksi. Naskah akan dikurasi oleh tim perencanaan konten sebelum diterbitkan.</p>
                <p><strong>Bagaimana cara bergabung menjadi anggota redaksi?</strong><br>
                Ikuti open recruitment yang diumumkan secara berkala, atau lihat halaman <a href="{{ route('public.page', 'karier') }}">karier</a>.</p>
                <p><strong>Apakah konten NewsHub boleh dibagikan ulang?</strong><br>
                Boleh, dengan mencantumkan sumber dan tautan ke artikel asli. Lihat <a href="{{ route('public.page', 'syarat-ketentuan') }}">Syarat &amp; Ketentuan</a> untuk detailnya.</p>
                @break

            @case('kebijakan-privasi')
                <p>Kami menghargai privasi setiap pengunjung NewsHub. Kebijakan ini menjelaskan data apa yang kami kumpulkan dan bagaimana kami menggunakannya.</p>
                <h2>Data yang kami kumpulkan</h2>
                <ul>
                    <li><strong>Alamat email</strong> — hanya jika Anda mendaftar sebagai pelanggan newsletter.</li>
                    <li><strong>Data teknis</strong> — seperti jenis peramban dan halaman yang dikunjungi, untuk keperluan statistik.</li>
                </ul>
                <h2>Penggunaan data</h2>
                <p>Alamat email pelanggan hanya digunakan untuk mengirim ringkasan berita dan tidak dibagikan kepada pihak ketiga.</p>
                <h2>Penghapusan data</h2>
                <p>Anda dapat berhenti berlangganan dan meminta penghapusan data kapan saja dengan menghubungi kami melalui halaman <a href="{{ route('public.page', 'kontak') }}">kontak</a>.</p>
                @break

            @case('syarat-ketentuan')
                <p>Dengan mengakses NewsHub, Anda menyetujui syarat dan ketentuan berikut.</p>
                <h2>Penggunaan konten</h2>
                <ul>
                    <li>Seluruh konten adalah milik redaksi NewsHub ENT GEN 21.</li>
                    <li>Kutipan sebagian diperbolehkan dengan mencantumkan sumber dan tautan asli.</li>
                    <li>Penggunaan komersial memerlukan izin tertulis dari redaksi.</li>
                </ul>
                <h2>Tanggung jawab</h2>
                <p>Kami berusaha menjaga akurasi setiap konten, namun tidak bertanggung jawab atas kerugian yang timbul dari penggunaan informasi di situs ini.</p>
                <h2>Perubahan ketentuan</h2>
                <p>Ketentuan ini dapat diperbarui sewaktu-waktu. Perubahan berlaku sejak dipublikasikan di halaman ini.</p>
                @break
        @endswitch
    </div>
</div>
@endsection
