@extends('layouts.site')

@section('content')

    <section class="page-header">
        <div class="hero-blob"></div>
        <div class="container">
            <div class="eyebrow-tag">
                <span class="eyebrow-dot"></span>
                Tentang Kami
            </div>
            <h1 class="page-header-title">Menghadirkan pembinaan Qur'an yang tetap tertata, meski jarak memisahkan.</h1>
            <p class="page-header-desc">Tanwir Qurani lahir dari kebutuhan sederhana: guru dan peserta program tahfizh LAZ SIP tersebar di banyak tempat, tapi progres hafalan tetap harus bisa dipantau satu per satu.</p>
        </div>
    </section>

    <section class="section-program">
        <div class="container">
            <div class="section-header">
                <span class="section-label">Cerita Kami</span>
                <h2 class="section-title">Dari catatan buku ke satu dashboard</h2>
                <p class="section-desc">Sebelum Tanwir Qurani ada, pemantauan setoran hafalan dilakukan manual — dicatat guru satu-satu, direkap ulang untuk laporan ke LAZ SIP. Prosesnya berjalan, tapi progres peserta jadi lambat terlihat, dan guru menghabiskan waktu untuk hal administratif yang sebenarnya bisa disederhanakan.</p>
            </div>

            <div class="timeline">
                <div class="timeline-item">
                    <div class="timeline-marker">
                        <div class="timeline-dot"></div>
                        <div class="timeline-line"></div>
                    </div>
                    <div>
                        <div class="timeline-year">Sebelum Digitalisasi</div>
                        <div class="timeline-title">Pencatatan manual per kelompok</div>
                        <div class="timeline-desc">Guru mencatat setoran hafalan peserta secara manual, laporan direkap berkala untuk dilaporkan ke pengurus LAZ SIP. Rawan tercecer dan sulit dilihat progresnya secara real-time.</div>
                    </div>
                </div>
                <div class="timeline-item">
                    <div class="timeline-marker">
                        <div class="timeline-dot"></div>
                        <div class="timeline-line"></div>
                    </div>
                    <div>
                        <div class="timeline-year">Tahap Awal</div>
                        <div class="timeline-title">Digitalisasi setoran hafalan</div>
                        <div class="timeline-desc">Tanwir Qurani dibangun sebagai platform digital pertama LAZ SIP untuk program tahfizh — peserta bisa kirim setoran suara dan video langsung dari browser, guru meninjau tanpa perlu bertemu langsung.</div>
                    </div>
                </div>
                <div class="timeline-item">
                    <div class="timeline-marker">
                        <div class="timeline-dot"></div>
                    </div>
                    <div>
                        <div class="timeline-year">Sekarang</div>
                        <div class="timeline-title">Satu sistem, tiga peran terhubung</div>
                        <div class="timeline-desc">Admin, guru (PIC kelompok), dan peserta kini berjalan dalam satu alur yang sama — mulai dari setoran, koreksi, kuis, sampai pencatatan data anak didik di tiap TPQ, semuanya tercatat rapi di satu tempat.</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section-program alt">
        <div class="container">
            <div class="section-header">
                <span class="section-label">Yang Kami Pegang</span>
                <h2 class="section-title">Nilai yang membentuk cara kami membangun</h2>
            </div>

            <div class="value-grid">
                <div class="value-card">
                    <div class="value-icon">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2 2 7l10 5 10-5-10-5Z"/><path d="m2 17 10 5 10-5"/><path d="m2 12 10 5 10-5"/></svg>
                    </div>
                    <div class="value-title">Amanah</div>
                    <div class="value-desc">Setiap setoran dan catatan progres dijaga akurat, karena ini menyangkut perjalanan belajar seseorang.</div>
                </div>
                <div class="value-card">
                    <div class="value-icon">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                    </div>
                    <div class="value-title">Konsisten</div>
                    <div class="value-desc">Sistem dirancang supaya kebiasaan menyetor dan mengoreksi bisa jalan terus, bukan cuma di awal semangat.</div>
                </div>
                <div class="value-card">
                    <div class="value-icon">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    </div>
                    <div class="value-title">Terhubung</div>
                    <div class="value-desc">Guru sebagai PIC tetap bisa memantau semua kelompok binaannya tanpa harus berpindah tempat.</div>
                </div>
                <div class="value-card">
                    <div class="value-icon">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 20h9"/><path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4Z"/></svg>
                    </div>
                    <div class="value-title">Sederhana</div>
                    <div class="value-desc">Satu kode akun, satu login — tanpa proses rumit yang bikin peserta atau guru enggan pakai.</div>
                </div>
            </div>
        </div>
    </section>

    <section class="cta-band">
        <div class="container cta-inner">
            <div>
                <div class="cta-tag">LAZ Solidaritas Insan Peduli</div>
                <h2 class="cta-title">Bagian dari program pemberdayaan LAZ SIP</h2>
                <p class="cta-sub">Tanwir Qurani adalah salah satu program digital LAZ SIP untuk mendukung pembinaan Qur'an masyarakat binaan.</p>
            </div>
            <div class="cta-actions">
                <a href="{{ url('/program') }}" class="btn-cta-white">Lihat Program</a>
                <a href="{{ url('/kontak') }}" class="btn-cta-outline">Hubungi Kami</a>
            </div>
        </div>
    </section>

@endsection
