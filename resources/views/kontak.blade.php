@extends('layouts.site')

@section('content')

    <section class="page-header">
        <div class="hero-blob"></div>
        <div class="container">
            <div class="eyebrow-tag">
                <span class="eyebrow-dot"></span>
                Kontak
            </div>
            <h1 class="page-header-title">Ada pertanyaan? Kami siap membantu.</h1>
            <p class="page-header-desc">Untuk pendaftaran akun baru, reset password, atau kendala teknis lainnya, hubungi admin lewat salah satu kanal di bawah.</p>
        </div>
    </section>

    <section class="section-program">
        <div class="container">
            <div class="contact-grid">
                <div class="contact-card">
                    <div class="contact-icon green">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5Z"/></svg>
                    </div>
                    <div class="contact-title">WhatsApp Admin</div>
                    <div class="contact-desc">Cara tercepat untuk pendaftaran akun, reset password, atau pertanyaan seputar penggunaan aplikasi.</div>
                    <a href="https://wa.me/628111186626" target="_blank" class="contact-link">
                        Chat via WhatsApp
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="7" y1="17" x2="17" y2="7"/><polyline points="7 7 17 7 17 17"/></svg>
                    </a>
                </div>

                <div class="contact-card">
                    <div class="contact-icon orange">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                    </div>
                    <div class="contact-title">Kantor Operasional</div>
                    <div class="contact-desc">LAZ Solidaritas Insan Peduli — Kabupaten Bogor, Provinsi Jawa Barat.</div>
                    <span class="contact-link" style="color: var(--ink-500); cursor: default;">Kab. Bogor, Jawa Barat</span>
                </div>

                <div class="contact-card">
                    <div class="contact-icon green">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 7-10 6L2 7"/></svg>
                    </div>
                    <div class="contact-title">Untuk Guru & Peserta Aktif</div>
                    <div class="contact-desc">Sudah punya kode akun tapi mengalami kendala login atau upload setoran? Sertakan kode akun saat menghubungi admin agar lebih cepat ditangani.</div>
                    <a href="{{ url('/login') }}" class="contact-link">
                        Ke halaman login
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="7" y1="17" x2="17" y2="7"/><polyline points="7 7 17 7 17 17"/></svg>
                    </a>
                </div>
            </div>

            <div class="contact-map-note">
                <div class="float-icon green" style="width: 3rem; height: 3rem;">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                </div>
                <div>
                    <div class="prog-title" style="margin-bottom: 0.3rem;">Jam Layanan Admin</div>
                    <div class="prog-desc">Senin – Sabtu, 08.00 – 17.00 WIB. Pesan di luar jam tersebut akan dibalas pada hari kerja berikutnya.</div>
                </div>
            </div>
        </div>
    </section>

@endsection
