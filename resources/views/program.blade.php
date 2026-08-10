@extends('layouts.site')

@section('content')

    <section class="page-header">
        <div class="hero-blob"></div>
        <div class="container">
            <div class="eyebrow-tag">
                <span class="eyebrow-dot"></span>
                Program & Fitur
            </div>
            <h1 class="page-header-title">Satu platform untuk tiga peran: admin, guru, dan peserta.</h1>
            <p class="page-header-desc">Tiap peran punya alurnya sendiri, tapi semuanya bertemu di satu tempat yang sama — supaya tidak ada yang tercecer.</p>
        </div>
    </section>

    <section class="section-program">
        <div class="container">
            <div class="section-header">
                <span class="section-label">Untuk Peserta (Guru Ngaji)</span>
                <h2 class="section-title">Kirim setoran tanpa keluar dari satu halaman</h2>
                <p class="section-desc">Peserta di sini adalah guru ngaji yang membina anak-anak di TPQ masing-masing — mereka menyetor hafalan dan mencatat perkembangan santrinya sendiri.</p>
            </div>

            <div class="program-grid">
                <div class="program-card border-green">
                    <div class="prog-icon-box green">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2a3 3 0 0 0-3 3v7a3 3 0 0 0 6 0V5a3 3 0 0 0-3-3Z"/><path d="M19 10v1a7 7 0 0 1-14 0v-1"/><line x1="12" y1="19" x2="12" y2="22"/></svg>
                    </div>
                    <h3 class="prog-title">Setoran Voice & Video</h3>
                    <p class="prog-desc">Rekam langsung dari browser atau unggah file — tanpa aplikasi tambahan, tanpa install apa pun.</p>
                </div>
                <div class="program-card border-orange">
                    <div class="prog-icon-box orange">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    </div>
                    <h3 class="prog-title">Kuis Pilihan Ganda</h3>
                    <p class="prog-desc">Kerjakan langsung di web, nilai keluar otomatis begitu selesai — tanpa menunggu koreksi manual.</p>
                </div>
                <div class="program-card border-green">
                    <div class="prog-icon-box green">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    </div>
                    <h3 class="prog-title">Data Anak Didik</h3>
                    <p class="prog-desc">Catat nama, usia, kelas, kontak orang tua, sampai progres belajar tiap santri di TPQ sendiri.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="section-program alt">
        <div class="container">
            <div class="section-header">
                <span class="section-label">Untuk Guru (PIC Kelompok)</span>
                <h2 class="section-title">Menaungi banyak peserta dari satu dashboard</h2>
                <p class="section-desc">Guru di sini berperan sebagai PIC yang lebih berilmu, menaungi satu atau lebih kelompok peserta (guru ngaji) sekaligus.</p>
            </div>

            <div class="program-grid">
                <div class="program-card border-orange">
                    <div class="prog-icon-box orange">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                    </div>
                    <h3 class="prog-title">Antrean Koreksi</h3>
                    <p class="prog-desc">Semua setoran yang masuk berbaris rapi di satu daftar — dengarkan, tonton, lalu setujui atau beri catatan.</p>
                </div>
                <div class="program-card border-green">
                    <div class="prog-icon-box green">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 3v18h18"/><path d="m19 9-5 5-4-4-3 3"/></svg>
                    </div>
                    <h3 class="prog-title">Progres per Kelompok</h3>
                    <p class="prog-desc">Pantau perkembangan seluruh peserta di kelompok yang diampu, tanpa perlu tanya satu-satu.</p>
                </div>
                <div class="program-card border-orange">
                    <div class="prog-icon-box orange">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 11H5a2 2 0 0 0-2 2v7a2 2 0 0 0 2 2h4"/><path d="M9 21V3a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v18"/></svg>
                    </div>
                    <h3 class="prog-title">Rekap Hasil Tugas & Kuis</h3>
                    <p class="prog-desc">Lihat riwayat lengkap kapan setiap setoran dikumpulkan, termasuk keterangan tepat waktu atau terlambat.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="section-program">
        <div class="container">
            <div class="section-header">
                <span class="section-label">Untuk Admin</span>
                <h2 class="section-title">Kontrol penuh atas struktur program</h2>
                <p class="section-desc">Admin mengatur pondasi: siapa jadi guru, siapa jadi peserta, kelompok mana dipegang siapa.</p>
            </div>

            <div class="program-grid cols-2">
                <div class="program-card border-green">
                    <div class="prog-icon-box green">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                    </div>
                    <h3 class="prog-title">Kelola Guru, Peserta & Kelompok</h3>
                    <p class="prog-desc">Tambah akun baru dengan kode login otomatis, atur kelompok dan tentukan PIC guru yang menaunginya.</p>
                </div>
                <div class="program-card border-orange">
                    <div class="prog-icon-box orange">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    </div>
                    <h3 class="prog-title">Monitor Tugas Menyeluruh</h3>
                    <p class="prog-desc">Lihat semua tugas dan setoran lintas kelompok dari satu dashboard — tanpa perlu masuk ke tiap akun guru.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="cta-band">
        <div class="container cta-inner">
            <div>
                <div class="cta-tag">Siap Mulai?</div>
                <h2 class="cta-title">Masuk dengan kode akun yang sudah didaftarkan</h2>
                <p class="cta-sub">Belum punya akun? Hubungi admin untuk didaftarkan sesuai peran dan kelompok Anda.</p>
            </div>
            <div class="cta-actions">
                <a href="{{ url('/login') }}" class="btn-cta-white">Masuk Sekarang</a>
                <a href="{{ url('/kontak') }}" class="btn-cta-outline">Hubungi Admin</a>
            </div>
        </div>
    </section>

@endsection
