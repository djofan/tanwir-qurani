@extends('layouts.site')

@section('content')

    <section class="page-header">
        <div class="hero-blob"></div>
        <div class="container">
            <div class="eyebrow-tag">
                <span class="eyebrow-dot"></span>
                Pertanyaan Umum
            </div>
            <h1 class="page-header-title">Yang biasa ditanyakan sebelum mulai.</h1>
            <p class="page-header-desc">Kalau jawabannya belum ada di sini, langsung saja hubungi admin lewat halaman kontak.</p>
        </div>
    </section>

    <section class="section-program">
        <div class="container">

            <div class="faq-category">Akun & Login</div>
            <div class="faq-list">
                <details class="faq-item" open>
                    <summary>
                        Bagaimana cara mendapatkan kode akun?
                        <span class="faq-icon"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg></span>
                    </summary>
                    <div class="faq-answer">Kode akun dibuat dan diberikan oleh admin LAZ SIP. Peserta dan guru baru perlu didaftarkan terlebih dahulu oleh admin — hubungi admin lewat halaman Kontak untuk pendaftaran.</div>
                </details>
                <details class="faq-item">
                    <summary>
                        Kenapa login pakai kode, bukan email?
                        <span class="faq-icon"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg></span>
                    </summary>
                    <div class="faq-answer">Supaya lebih mudah diingat dan tidak semua peserta wajib punya email aktif. Kode akun otomatis dibuat sesuai peran, misalnya format GTQ001 untuk guru dan PTQ001 untuk peserta.</div>
                </details>
                <details class="faq-item">
                    <summary>
                        Lupa password, bagaimana cara reset-nya?
                        <span class="faq-icon"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg></span>
                    </summary>
                    <div class="faq-answer">Password hanya bisa direset oleh admin. Hubungi admin lewat WhatsApp di halaman Kontak dengan menyebutkan kode akun Anda.</div>
                </details>
            </div>

            <div class="faq-category">Setoran & Tugas</div>
            <div class="faq-list">
                <details class="faq-item">
                    <summary>
                        Format setoran apa saja yang bisa dikirim?
                        <span class="faq-icon"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg></span>
                    </summary>
                    <div class="faq-answer">Tergantung jenis tugas yang dibuat guru: bisa berupa rekaman suara (voice note), video, atau kuis pilihan ganda. Rekaman voice/video bisa direkam langsung dari browser atau diunggah dari file yang sudah ada.</div>
                </details>
                <details class="faq-item">
                    <summary>
                        Bagaimana kalau setoran ditolak guru?
                        <span class="faq-icon"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg></span>
                    </summary>
                    <div class="faq-answer">Setoran yang ditolak bisa dikirim ulang. Setiap percobaan tercatat sebagai riwayat tersendiri, lengkap dengan catatan dari guru, jadi peserta tahu persis bagian mana yang perlu diperbaiki.</div>
                </details>
                <details class="faq-item">
                    <summary>
                        Apa bedanya "Tepat Waktu" dan "Terlambat"?
                        <span class="faq-icon"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg></span>
                    </summary>
                    <div class="faq-answer">Ini menandai apakah setoran dikirim sebelum atau sesudah tenggat waktu yang ditentukan guru untuk tugas tersebut. Keduanya tetap bisa dikoreksi, tapi status ini membantu guru memantau kedisiplinan peserta.</div>
                </details>
            </div>

            <div class="faq-category">Kelompok & Peran</div>
            <div class="faq-list">
                <details class="faq-item">
                    <summary>
                        Apa itu "PIC" pada kelompok?
                        <span class="faq-icon"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg></span>
                    </summary>
                    <div class="faq-answer">PIC adalah guru yang bertanggung jawab menaungi satu kelompok peserta. Satu guru bisa menjadi PIC untuk lebih dari satu kelompok, dan hanya bisa melihat data peserta di kelompok yang ia naungi.</div>
                </details>
                <details class="faq-item">
                    <summary>
                        Peserta di sini maksudnya siapa?
                        <span class="faq-icon"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg></span>
                    </summary>
                    <div class="faq-answer">Peserta dalam sistem ini adalah guru ngaji yang aktif membina anak-anak di TPQ masing-masing. Mereka menyetor hafalan pribadi ke guru (PIC), sekaligus mencatat data santri yang mereka ajar.</div>
                </details>
            </div>

        </div>
    </section>

    <section class="cta-band">
        <div class="container cta-inner">
            <div>
                <div class="cta-tag">Masih Ada Pertanyaan?</div>
                <h2 class="cta-title">Tim admin siap membantu</h2>
                <p class="cta-sub">Kirim pesan langsung lewat WhatsApp, biasanya direspons di jam kerja.</p>
            </div>
            <div class="cta-actions">
                <a href="{{ url('/kontak') }}" class="btn-cta-white">Hubungi Kami</a>
            </div>
        </div>
    </section>

@endsection
