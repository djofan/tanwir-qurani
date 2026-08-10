@extends('layouts.site')

@section('content')

    <!-- HERO -->
    <section class="hero">
        <div class="hero-blob"></div>
        <div class="hero-blob-2"></div>
        <div class="container">
            <div class="hero-layout">
                <div>
                    <div class="eyebrow-tag">
                        <span class="eyebrow-dot"></span>
                        Program Digital LAZ Solidaritas Insan Peduli
                    </div>

                    <h1 class="hero-title">
                        Setoran hafalan jadi <span class="hl-orange">lebih mudah</span>,
                        progres jadi <span class="hl-green">lebih jelas</span>.
                    </h1>

                    <p class="hero-desc">
                        Tanwir Qurani membantu peserta mengirim setoran, mengikuti kuis, dan memantau perkembangan — sementara guru bisa meninjau dan memberi feedback tanpa ribet. Cukup satu akun, satu kode login.
                    </p>

                    <div class="hero-actions">
                        <a href="{{ url('/login') }}" class="btn-primary">
                            Masuk dengan Kode Akun
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                        </a>
                        <a href="{{ url('/kontak') }}" class="btn-secondary">Belum Punya Kode?</a>
                    </div>

                    <div class="hero-stats-row">
                        <div>
                            <div class="stat-num"><span>100%</span></div>
                            <div class="stat-label">Berbasis Syariah</div>
                        </div>
                        <div>
                            <div class="stat-num"><span>30+</span></div>
                            <div class="stat-label">Juz Terverifikasi</div>
                        </div>
                        <div>
                            <div class="stat-num"><span>1</span></div>
                            <div class="stat-label">Akun, Semua Fitur</div>
                        </div>
                    </div>
                </div>

                <div class="hero-visual">
                    <div class="float-card">
                        <div class="float-icon green">
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2a3 3 0 0 0-3 3v7a3 3 0 0 0 6 0V5a3 3 0 0 0-3-3Z"/><path d="M19 10v1a7 7 0 0 1-14 0v-1"/><line x1="12" y1="19" x2="12" y2="22"/></svg>
                        </div>
                        <div>
                            <div class="float-title">Setoran Voice & Video</div>
                            <div class="float-desc">Rekam langsung dari browser atau upload file, tanpa aplikasi tambahan.</div>
                        </div>
                    </div>

                    <div class="float-card">
                        <div class="float-icon orange">
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                        </div>
                        <div>
                            <div class="float-title">Kuis Langsung di Web</div>
                            <div class="float-desc">Kerjakan kuis pilihan ganda langsung di aplikasi, nilai keluar otomatis.</div>
                        </div>
                    </div>

                    <div class="float-card">
                        <div class="float-icon green">
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 3v18h18"/><path d="m19 9-5 5-4-4-3 3"/></svg>
                        </div>
                        <div>
                            <div class="float-title">Progres Real-Time</div>
                            <div class="float-desc">Guru memantau perkembangan setiap kelompok dalam satu dashboard.</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CARA KERJA -->
    <section class="section-program" id="program">
        <div class="container">
            <div class="section-header">
                <span class="section-label">Cara Kerja</span>
                <h2 class="section-title">Tiga langkah, satu alur yang rapi</h2>
                <p class="section-desc">Dari pengiriman setoran sampai rekap pencapaian, semua langkah dirancang supaya peserta dan guru tidak perlu bingung di tengah jalan.</p>
            </div>

            <div class="program-grid">
                <div class="program-card border-green">
                    <div class="prog-icon-box green">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2a3 3 0 0 0-3 3v7a3 3 0 0 0 6 0V5a3 3 0 0 0-3-3Z"/><path d="M19 10v1a7 7 0 0 1-14 0v-1"/><line x1="12" y1="19" x2="12" y2="22"/></svg>
                    </div>
                    <h3 class="prog-title">Kirim setoran atau kuis</h3>
                    <p class="prog-desc">Peserta merekam hafalan langsung dari browser atau mengunggah file, dan mengerjakan kuis pilihan ganda langsung di web.</p>
                </div>

                <div class="program-card border-orange">
                    <div class="prog-icon-box orange">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    </div>
                    <h3 class="prog-title">Guru meninjau langsung</h3>
                    <p class="prog-desc">Setiap setoran masuk ke antrean koreksi. Guru mendengarkan, menonton, lalu memberi catatan atau menyetujui — kuis dinilai otomatis.</p>
                </div>

                <div class="program-card border-green">
                    <div class="prog-icon-box green">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 3v18h18"/><path d="M18.7 8l-5.1 5.2-2.8-2.7L7 14.3"/></svg>
                    </div>
                    <h3 class="prog-title">Progres tercatat otomatis</h3>
                    <p class="prog-desc">Setiap hasil koreksi langsung memperbarui dashboard, jadi perkembangan selalu terlihat tanpa rekap manual.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="cta-band">
        <div class="container cta-inner">
            <div>
                <div class="cta-tag">Bergabung Sekarang</div>
                <h2 class="cta-title">Siap melanjutkan progres kamu?</h2>
                <p class="cta-sub">Terbuka untuk peserta & guru aktif program Tanwir Qurani LAZ SIP. Masuk dengan kode akun yang sudah didaftarkan admin.</p>
            </div>
            <div class="cta-actions">
                <a href="{{ url('/login') }}" class="btn-cta-white">Masuk Sekarang</a>
                <a href="https://wa.me/628111186626" target="_blank" class="btn-cta-outline">Hubungi Admin</a>
            </div>
        </div>
    </section>

@endsection
