<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? config('app.name', 'Tanwir Qurani') }}</title>
    <meta name="description" content="{{ $metaDescription ?? 'Platform digital setoran hafalan, kuis, dan pemantauan progres santri LAZ Solidaritas Insan Peduli.' }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Amiri:ital,wght@0,400;1,400&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --green-700: #4d7c2e;
            --green-600: #6fa84e;
            --green-500: #7cb342;
            --green-100: #eef6e6;
            --orange-600: #e8920f;
            --orange-500: #f5a623;
            --orange-100: #fef3e0;
            --ink-900: #1f2924;
            --ink-700: #3d4a42;
            --ink-500: #6b7873;
            --paper: #fcfbf7;
            --paper-card: #ffffff;
        }

        html { scroll-behavior: smooth; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--paper);
            color: var(--ink-900);
            min-height: 100vh;
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
        }

        .container { max-width: 1180px; margin: 0 auto; padding: 0 1.5rem; }

        /* ── NAVBAR ───────────────────────────────── */
        .navbar {
            position: fixed; top: 0; left: 0; right: 0; z-index: 100;
            background: rgba(252, 251, 247, 0.88);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            border-bottom: 1px solid rgba(31, 41, 36, 0.07);
        }
        .navbar-inner {
            display: flex; align-items: center; justify-content: space-between;
            height: 4.75rem; gap: 1.5rem;
        }
        .navbar-brand { display: flex; align-items: center; gap: 0.6rem; text-decoration: none; flex-shrink: 0; }
        .navbar-brand img { height: 38px; width: auto; }
        .brand-divider { width: 1px; height: 28px; background: rgba(31,41,36,0.12); }
        .brand-text-group { display: flex; flex-direction: column; line-height: 1.1; }
        .brand-text { font-size: 1rem; font-weight: 700; color: var(--ink-900); }
        .brand-sub { font-size: 0.65rem; font-weight: 500; color: var(--ink-500); letter-spacing: 0.04em; }

        .navbar-menu { display: flex; align-items: center; gap: 2rem; margin-left: auto; }
        .navbar-menu a {
            font-size: 0.88rem; font-weight: 600; color: var(--ink-700); text-decoration: none;
            position: relative; padding: 0.3rem 0; transition: color 0.2s;
        }
        .navbar-menu a:hover { color: var(--green-700); }
        .navbar-menu a.active { color: var(--green-700); }
        .navbar-menu a.active::after {
            content: ''; position: absolute; left: 0; right: 0; bottom: -2px; height: 2px;
            background: var(--orange-500); border-radius: 2px;
        }

        .navbar-actions { display: flex; align-items: center; gap: 0.75rem; }
        .btn-nav-primary {
            font-size: 0.85rem; font-weight: 700; color: #fff; text-decoration: none;
            padding: 0.65rem 1.4rem; border-radius: 10px;
            background: var(--orange-500);
            box-shadow: 0 4px 14px rgba(245, 166, 35, 0.35);
            transition: all 0.2s ease;
            white-space: nowrap;
        }
        .btn-nav-primary:hover { background: var(--orange-600); transform: translateY(-1px); }

        .navbar-toggle {
            display: none; flex-direction: column; gap: 4px; background: none; border: none; cursor: pointer; padding: 0.4rem;
        }
        .navbar-toggle span { width: 22px; height: 2px; background: var(--ink-900); border-radius: 2px; }

        /* ── HERO (halaman utama) ─────────────────── */
        .hero {
            padding: 10rem 0 5rem;
            position: relative;
            background: var(--paper);
            overflow: hidden;
        }
        .hero-blob {
            position: absolute; top: -120px; right: -160px;
            width: 480px; height: 480px; border-radius: 50%;
            background: radial-gradient(circle, rgba(124,179,66,0.16), transparent 70%);
            pointer-events: none;
        }
        .hero-blob-2 {
            position: absolute; bottom: -100px; left: -120px;
            width: 360px; height: 360px; border-radius: 50%;
            background: radial-gradient(circle, rgba(245,166,35,0.12), transparent 70%);
            pointer-events: none;
        }

        .eyebrow-tag {
            display: inline-flex; align-items: center; gap: 0.5rem;
            font-size: 0.78rem; font-weight: 700; color: var(--green-700);
            background: var(--green-100);
            border-radius: 50px; padding: 0.45rem 1rem 0.45rem 0.7rem;
            margin-bottom: 1.75rem;
        }
        .eyebrow-dot { width: 7px; height: 7px; border-radius: 50%; background: var(--orange-500); }

        .hero-layout {
            display: grid;
            grid-template-columns: 1fr;
            gap: 2.5rem;
            position: relative;
        }

        .hero-title {
            font-size: clamp(2.4rem, 5vw, 3.6rem);
            font-weight: 800;
            line-height: 1.12;
            letter-spacing: -0.02em;
            color: var(--ink-900);
            max-width: 760px;
        }
        .hero-title .hl-green { color: var(--green-600); }
        .hero-title .hl-orange { position: relative; color: var(--ink-900); }
        .hero-title .hl-orange::after {
            content: '';
            position: absolute; left: 0; right: 0; bottom: 0.08em; height: 0.32em;
            background: var(--orange-100);
            z-index: -1;
        }

        .hero-desc {
            font-size: 1.05rem; line-height: 1.75; color: var(--ink-500);
            max-width: 560px; margin-top: 1.5rem;
        }

        .hero-actions { display: flex; align-items: center; gap: 1rem; margin-top: 2.25rem; flex-wrap: wrap; }

        .btn-primary {
            display: inline-flex; align-items: center; gap: 0.55rem;
            font-size: 0.95rem; font-weight: 700; color: #fff; text-decoration: none;
            padding: 0.9rem 1.9rem; border-radius: 12px;
            background: linear-gradient(135deg, var(--orange-500), var(--orange-600));
            box-shadow: 0 8px 22px rgba(245, 166, 35, 0.32);
            transition: all 0.25s ease;
            border: none; cursor: pointer;
        }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 12px 28px rgba(245, 166, 35, 0.42); }

        .btn-secondary {
            display: inline-flex; align-items: center; gap: 0.55rem;
            font-size: 0.95rem; font-weight: 700; color: var(--green-700); text-decoration: none;
            padding: 0.9rem 1.7rem; border-radius: 12px;
            border: 1.5px solid var(--green-600);
            transition: all 0.2s;
        }
        .btn-secondary:hover { background: var(--green-100); }

        .hero-stats-row {
            display: flex; gap: 2.5rem; margin-top: 3.5rem;
            padding-top: 2rem; border-top: 1px solid rgba(31,41,36,0.08);
            flex-wrap: wrap;
        }
        .stat-num { font-size: 1.9rem; font-weight: 800; color: var(--ink-900); line-height: 1; margin-bottom: 0.3rem; }
        .stat-num span { color: var(--green-600); }
        .stat-label { font-size: 0.78rem; color: var(--ink-500); font-weight: 600; }

        .hero-visual {
            position: relative;
            display: flex; flex-direction: column; gap: 1rem;
        }
        .float-card {
            background: var(--paper-card);
            border: 1px solid rgba(31,41,36,0.07);
            border-radius: 18px;
            padding: 1.4rem 1.5rem;
            display: flex; align-items: flex-start; gap: 1rem;
            box-shadow: 0 8px 24px rgba(31,41,36,0.05);
        }
        .float-icon {
            width: 2.75rem; height: 2.75rem; border-radius: 11px;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }
        .float-icon.green { background: var(--green-100); color: var(--green-700); }
        .float-icon.orange { background: var(--orange-100); color: var(--orange-600); }
        .float-title { font-size: 0.95rem; font-weight: 700; color: var(--ink-900); margin-bottom: 0.2rem; }
        .float-desc { font-size: 0.83rem; color: var(--ink-500); line-height: 1.55; }

        /* ── PAGE HEADER (halaman non-beranda) ────── */
        .page-header {
            padding: 9.5rem 0 3.5rem;
            position: relative;
            background: var(--paper);
            overflow: hidden;
        }
        .page-header-title {
            font-size: clamp(2rem, 4vw, 2.75rem);
            font-weight: 800; letter-spacing: -0.02em; color: var(--ink-900);
            max-width: 700px;
        }
        .page-header-desc {
            font-size: 1.02rem; color: var(--ink-500); line-height: 1.7;
            max-width: 620px; margin-top: 1rem;
        }

        /* ── PROGRAM/SECTION GRID ─────────────────── */
        .section-program { padding: 6rem 0; background: #fff; }
        .section-program.alt { background: var(--paper); }

        .section-header { max-width: 620px; margin-bottom: 3.5rem; }
        .section-label {
            font-size: 0.78rem; font-weight: 700; letter-spacing: 0.1em; text-transform: uppercase;
            color: var(--orange-600); display: block; margin-bottom: 0.6rem;
        }
        .section-title { font-size: 2rem; font-weight: 800; color: var(--ink-900); letter-spacing: -0.01em; margin-bottom: 0.8rem; }
        .section-desc { font-size: 1rem; color: var(--ink-500); line-height: 1.7; }

        .program-grid {
            display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.75rem;
        }
        .program-grid.cols-2 { grid-template-columns: repeat(2, 1fr); }
        .program-card {
            background: var(--paper);
            padding: 2.25rem 1.9rem;
            border-radius: 18px;
            border: 1px solid rgba(31,41,36,0.06);
            transition: all 0.3s ease;
            position: relative;
        }
        .section-program.alt .program-card { background: #fff; }
        .program-card:hover { transform: translateY(-5px); box-shadow: 0 16px 32px rgba(31,41,36,0.08); }
        .program-card.border-green { border-top: 3px solid var(--green-600); }
        .program-card.border-orange { border-top: 3px solid var(--orange-500); }

        .prog-icon-box {
            width: 3.25rem; height: 3.25rem; border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            margin-bottom: 1.4rem;
        }
        .prog-icon-box.green { background: var(--green-100); color: var(--green-700); }
        .prog-icon-box.orange { background: var(--orange-100); color: var(--orange-600); }

        .prog-title { font-size: 1.15rem; font-weight: 700; color: var(--ink-900); margin-bottom: 0.65rem; }
        .prog-desc { font-size: 0.9rem; color: var(--ink-500); line-height: 1.65; }

        /* ── TIMELINE (Tentang) ───────────────────── */
        .timeline { display: flex; flex-direction: column; gap: 0; max-width: 720px; }
        .timeline-item { display: flex; gap: 1.5rem; padding-bottom: 2.5rem; position: relative; }
        .timeline-item:last-child { padding-bottom: 0; }
        .timeline-marker { display: flex; flex-direction: column; align-items: center; flex-shrink: 0; }
        .timeline-dot { width: 12px; height: 12px; border-radius: 50%; background: var(--green-600); border: 3px solid var(--green-100); flex-shrink: 0; margin-top: 0.3rem; }
        .timeline-line { width: 2px; flex: 1; background: rgba(31,41,36,0.1); margin-top: 0.4rem; }
        .timeline-year { font-size: 0.78rem; font-weight: 700; color: var(--orange-600); text-transform: uppercase; letter-spacing: 0.06em; margin-bottom: 0.35rem; }
        .timeline-title { font-size: 1.05rem; font-weight: 700; color: var(--ink-900); margin-bottom: 0.4rem; }
        .timeline-desc { font-size: 0.92rem; color: var(--ink-500); line-height: 1.65; }

        /* ── VALUE GRID (Tentang) ─────────────────── */
        .value-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 1.5rem; }
        .value-card { text-align: center; padding: 1.5rem 1rem; }
        .value-icon {
            width: 3.5rem; height: 3.5rem; border-radius: 50%; margin: 0 auto 1rem;
            display: flex; align-items: center; justify-content: center;
            background: var(--green-100); color: var(--green-700);
        }
        .value-title { font-size: 0.98rem; font-weight: 700; color: var(--ink-900); margin-bottom: 0.4rem; }
        .value-desc { font-size: 0.83rem; color: var(--ink-500); line-height: 1.55; }

        /* ── FAQ ACCORDION ─────────────────────────── */
        .faq-list { max-width: 780px; margin: 0 auto; display: flex; flex-direction: column; gap: 0.9rem; }
        .faq-item {
            background: #fff; border: 1px solid rgba(31,41,36,0.08); border-radius: 14px;
            overflow: hidden;
        }
        .faq-item summary {
            padding: 1.3rem 1.6rem; font-weight: 700; font-size: 0.98rem; color: var(--ink-900);
            cursor: pointer; list-style: none; display: flex; align-items: center; justify-content: space-between; gap: 1rem;
        }
        .faq-item summary::-webkit-details-marker { display: none; }
        .faq-icon {
            flex-shrink: 0; width: 1.6rem; height: 1.6rem; border-radius: 50%;
            background: var(--green-100); color: var(--green-700);
            display: flex; align-items: center; justify-content: center;
            transition: transform 0.25s ease;
        }
        .faq-item[open] .faq-icon { transform: rotate(45deg); background: var(--orange-100); color: var(--orange-600); }
        .faq-answer { padding: 0 1.6rem 1.5rem; font-size: 0.9rem; color: var(--ink-500); line-height: 1.7; }

        .faq-category {
            font-size: 0.78rem; font-weight: 700; letter-spacing: 0.08em; text-transform: uppercase;
            color: var(--green-700); margin: 3rem 0 1.2rem;
        }
        .faq-category:first-of-type { margin-top: 0; }

        /* ── KONTAK ─────────────────────────────────── */
        .contact-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.5rem; }
        .contact-card {
            background: #fff; border: 1px solid rgba(31,41,36,0.07); border-radius: 18px;
            padding: 2rem 1.75rem; text-align: left;
        }
        .contact-icon {
            width: 3rem; height: 3rem; border-radius: 12px; margin-bottom: 1.2rem;
            display: flex; align-items: center; justify-content: center;
        }
        .contact-icon.green { background: var(--green-100); color: var(--green-700); }
        .contact-icon.orange { background: var(--orange-100); color: var(--orange-600); }
        .contact-title { font-size: 1.02rem; font-weight: 700; color: var(--ink-900); margin-bottom: 0.5rem; }
        .contact-desc { font-size: 0.88rem; color: var(--ink-500); line-height: 1.6; margin-bottom: 1rem; }
        .contact-link { font-size: 0.85rem; font-weight: 700; color: var(--green-700); text-decoration: none; display: inline-flex; align-items: center; gap: 0.4rem; }
        .contact-link:hover { color: var(--orange-600); }

        .contact-map-note {
            margin-top: 3rem; background: var(--green-100); border-radius: 18px; padding: 2rem;
            display: flex; align-items: center; gap: 1.5rem; flex-wrap: wrap;
        }

        /* ── CTA ───────────────────────────────────── */
        .cta-band {
            background: linear-gradient(135deg, var(--green-700) 0%, var(--green-600) 100%);
            color: #fff; padding: 4.5rem 0; position: relative; overflow: hidden;
        }
        .cta-band::before {
            content: ''; position: absolute; top: -60px; right: -60px;
            width: 280px; height: 280px; border-radius: 50%;
            background: rgba(255,255,255,0.06);
        }
        .cta-inner { display: flex; align-items: center; justify-content: space-between; gap: 2.5rem; position: relative; z-index: 1; }
        .cta-tag { font-size: 0.78rem; font-weight: 700; letter-spacing: 0.08em; text-transform: uppercase; color: var(--orange-100); margin-bottom: 0.5rem; }
        .cta-title { font-size: 1.85rem; font-weight: 800; letter-spacing: -0.01em; margin-bottom: 0.6rem; max-width: 480px; }
        .cta-sub { font-size: 0.95rem; color: rgba(255,255,255,0.85); line-height: 1.65; max-width: 480px; }
        .cta-actions { display: flex; gap: 0.9rem; align-items: center; flex-shrink: 0; flex-wrap: wrap; }

        .btn-cta-white {
            background: #fff; color: var(--green-700); font-weight: 700; text-decoration: none;
            padding: 0.9rem 1.9rem; border-radius: 12px; transition: all 0.2s;
        }
        .btn-cta-white:hover { background: var(--orange-100); transform: translateY(-1px); }
        .btn-cta-outline {
            border: 1.5px solid rgba(255,255,255,0.4); color: #fff; font-weight: 700; text-decoration: none;
            padding: 0.9rem 1.7rem; border-radius: 12px; transition: all 0.2s;
        }
        .btn-cta-outline:hover { background: rgba(255,255,255,0.1); border-color: #fff; }

        /* ── FOOTER ────────────────────────────────── */
        .footer { background: var(--ink-900); padding: 3.5rem 0 2rem; color: rgba(255,255,255,0.6); font-size: 0.88rem; }
        .footer-top { display: flex; justify-content: space-between; gap: 2.5rem; flex-wrap: wrap; padding-bottom: 2.5rem; margin-bottom: 1.75rem; border-bottom: 1px solid rgba(255,255,255,0.08); }
        .footer-brand { display: flex; align-items: center; gap: 0.75rem; max-width: 320px; }
        .footer-brand img { height: 28px; filter: brightness(0) invert(1); opacity: 0.9; }
        .footer-brand-name { font-weight: 700; color: #fff; font-size: 0.95rem; }
        .footer-sub { font-size: 0.78rem; color: rgba(255,255,255,0.5); }
        .footer-links { display: flex; gap: 3.5rem; flex-wrap: wrap; }
        .footer-col-title { font-size: 0.78rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.06em; color: rgba(255,255,255,0.85); margin-bottom: 0.9rem; }
        .footer-col a { display: block; font-size: 0.85rem; color: rgba(255,255,255,0.55); text-decoration: none; margin-bottom: 0.6rem; transition: color 0.2s; }
        .footer-col a:hover { color: #fff; }
        .footer-inner { display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1.5rem; }

        /* ── RESPONSIVE ────────────────────────────── */
        @media (min-width: 968px) {
            .hero-layout { grid-template-columns: 1.15fr 0.85fr; align-items: center; }
        }
        @media (max-width: 968px) {
            .navbar-menu { display: none; }
            .navbar-menu.is-open {
                display: flex; flex-direction: column; gap: 0;
                position: absolute; top: 4.75rem; left: 0; right: 0;
                background: var(--paper); border-bottom: 1px solid rgba(31,41,36,0.07);
                padding: 0.5rem 1.5rem 1.25rem;
                box-shadow: 0 12px 24px rgba(31,41,36,0.06);
            }
            .navbar-menu.is-open a { padding: 0.85rem 0; border-bottom: 1px solid rgba(31,41,36,0.06); }
            .navbar-menu.is-open a.active::after { display: none; }
            .navbar-toggle { display: flex; }
            .program-grid { grid-template-columns: 1fr; }
            .program-grid.cols-2 { grid-template-columns: 1fr; }
            .value-grid { grid-template-columns: repeat(2, 1fr); }
            .contact-grid { grid-template-columns: 1fr; }
            .cta-inner { flex-direction: column; text-align: center; align-items: center; }
            .footer-inner { flex-direction: column; text-align: center; }
            .footer-top { flex-direction: column; gap: 2rem; }
        }
        @media (max-width: 576px) {
            .hero-actions { flex-direction: column; align-items: stretch; }
            .hero-stats-row { gap: 1.5rem; }
            .cta-actions { flex-direction: column; align-items: stretch; width: 100%; }
            .btn-primary, .btn-secondary, .btn-cta-white, .btn-cta-outline { text-align: center; justify-content: center; }
            .navbar-brand .brand-text-group { display: none; }
            .navbar-actions { gap: 0.5rem; }
            .btn-nav-primary { font-size: 0.78rem; padding: 0.5rem 0.85rem; }
            .value-grid { grid-template-columns: 1fr; }
        }

        @yield('extra-style')
    </style>
    @yield('head')
</head>
<body>

    <!-- NAVBAR -->
    <nav class="navbar">
        <div class="container navbar-inner">
            <a href="{{ url('/') }}" class="navbar-brand">
                <img src="{{ asset('images/logo.png') }}" alt="LAZ SIP">
                <div class="brand-divider"></div>
                <div class="brand-text-group">
                    <span class="brand-text">Tanwir Qurani</span>
                    <span class="brand-sub">LAZ Solidaritas Insan Peduli</span>
                </div>
            </a>
            <div class="navbar-menu">
                <a href="{{ url('/') }}" class="{{ request()->is('/') ? 'active' : '' }}">Beranda</a>
                <a href="{{ url('/tentang') }}" class="{{ request()->is('tentang') ? 'active' : '' }}">Tentang Kami</a>
                <a href="{{ url('/program') }}" class="{{ request()->is('program') ? 'active' : '' }}">Program</a>
                <a href="{{ url('/faq') }}" class="{{ request()->is('faq') ? 'active' : '' }}">FAQ</a>
                <a href="{{ url('/kontak') }}" class="{{ request()->is('kontak') ? 'active' : '' }}">Kontak</a>
            </div>
            <div class="navbar-actions">
                <a href="{{ url('/login') }}" class="btn-nav-primary">Masuk</a>
                <button class="navbar-toggle" aria-label="Buka menu">
                    <span></span><span></span><span></span>
                </button>
            </div>
        </div>
    </nav>

    @yield('content')

    <!-- FOOTER -->
    <footer class="footer">
        <div class="container">
            <div class="footer-top">
                <div class="footer-brand">
                    <img src="{{ asset('images/logo.png') }}" alt="LAZ SIP">
                    <div>
                        <div class="footer-brand-name">Tanwir Qurani</div>
                        <div class="footer-sub">Program Digital LAZ Solidaritas Insan Peduli · Kab. Bogor, Jawa Barat</div>
                    </div>
                </div>
                <div class="footer-links">
                    <div class="footer-col">
                        <div class="footer-col-title">Jelajahi</div>
                        <a href="{{ url('/tentang') }}">Tentang Kami</a>
                        <a href="{{ url('/program') }}">Program</a>
                        <a href="{{ url('/faq') }}">FAQ</a>
                    </div>
                    <div class="footer-col">
                        <div class="footer-col-title">Akun</div>
                        <a href="{{ url('/login') }}">Masuk</a>
                        <a href="{{ url('/kontak') }}">Hubungi Admin</a>
                    </div>
                </div>
            </div>
            <div class="footer-inner">
                <div class="footer-sub">
                    &copy; {{ date('Y') }} LAZ SIP · Seluruh hak dilindungi · v{{ app()->version() }}
                </div>
            </div>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var toggle = document.querySelector('.navbar-toggle');
            var menu = document.querySelector('.navbar-menu');
            if (toggle && menu) {
                toggle.addEventListener('click', function () {
                    menu.classList.toggle('is-open');
                });
            }
        });
    </script>
</body>
</html>
