<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — Tanwir Qurani</title>
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #0f172a 100%);
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        }
        .card {
            width: 100%;
            max-width: 380px;
            background: rgba(255,255,255,0.03);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 20px;
            padding: 36px 32px;
        }
        .brand {
            text-align: center;
            margin-bottom: 28px;
        }
        .brand h1 {
            color: #f1f5f9;
            font-size: 22px;
            font-weight: 800;
            margin: 0 0 4px;
        }
        .brand p {
            color: #64748b;
            font-size: 13px;
            margin: 0;
        }
        label {
            display: block;
            color: #94a3b8;
            font-size: 12.5px;
            font-weight: 600;
            margin-bottom: 6px;
        }
        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 11px 14px;
            border-radius: 10px;
            border: 1.5px solid rgba(148,163,184,0.2);
            background: rgba(255,255,255,0.02);
            color: #f1f5f9;
            font-size: 14px;
            margin-bottom: 16px;
        }
        .pw-wrap { position: relative; }
        .pw-wrap input { padding-right: 42px; margin-bottom: 0; }
        .pw-toggle {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            padding: 4px;
            cursor: pointer;
            color: #64748b;
            width: auto;
            display: flex;
        }
        .pw-toggle:hover { background: none; color: #94a3b8; }
        .pw-spacer { margin-bottom: 16px; }
        input:focus {
            outline: none;
            border-color: #22c55e;
        }
        button {
            width: 100%;
            padding: 12px;
            border-radius: 10px;
            border: none;
            background: #22c55e;
            color: #0f172a;
            font-weight: 700;
            font-size: 14px;
            cursor: pointer;
        }
        button:hover { background: #16a34a; }
        .error {
            background: rgba(239,68,68,0.1);
            border: 1px solid rgba(239,68,68,0.3);
            color: #f87171;
            padding: 10px 14px;
            border-radius: 10px;
            font-size: 12.5px;
            margin-bottom: 16px;
        }
        .footer-note {
            text-align: center;
            color: #475569;
            font-size: 11.5px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="card">
        <div class="brand">
            <h1>Tanwir Qurani</h1>
            <p>Masuk dengan kode akun kamu</p>
        </div>

        @if ($errors->any())
            <div class="error">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <label for="code">Kode Akun</label>
            <input type="text" id="code" name="code" value="{{ old('code') }}" placeholder="Contoh: GTQ001" autofocus autocapitalize="characters" autocomplete="off">

            <label for="password">Password</label>
            <div class="pw-wrap pw-spacer">
                <input type="password" id="password" name="password" placeholder="••••••••" autocomplete="off">
                <button type="button" class="pw-toggle" onclick="togglePw()" aria-label="Lihat/sembunyikan password">
                    <svg id="pw-icon-show" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8Z"/><circle cx="12" cy="12" r="3"/></svg>
                    <svg id="pw-icon-hide" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:none;"><path d="M17.94 17.94A10.94 10.94 0 0 1 12 20c-7 0-11-8-11-8a21.6 21.6 0 0 1 5.06-6.06M9.9 4.24A10.4 10.4 0 0 1 12 4c7 0 11 8 11 8a21.6 21.6 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/></svg>
                </button>
            </div>

            <button type="submit">Masuk</button>
        </form>

        <p class="footer-note">Lupa kode akun? Hubungi admin.</p>
    </div>

    <script>
        function togglePw() {
            const input = document.getElementById('password');
            const showIcon = document.getElementById('pw-icon-show');
            const hideIcon = document.getElementById('pw-icon-hide');
            const isHidden = input.type === 'password';
            input.type = isHidden ? 'text' : 'password';
            showIcon.style.display = isHidden ? 'none' : 'block';
            hideIcon.style.display = isHidden ? 'block' : 'none';
        }
    </script>
</body>
</html>
