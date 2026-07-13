<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class PortalLoginController extends Controller
{
    public function show(): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect($this->panelPathForUser(Auth::user()));
        }

        return view('auth.portal-login');
    }

    public function login(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'code'     => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $user = User::where('code', $data['code'])->first();

        if (! $user || ! Hash::check($data['password'], $user->password)) {
            return back()
                ->withErrors(['code' => 'Kode akun atau password salah.'])
                ->onlyInput('code');
        }

        if (! $user->status) {
            return back()
                ->withErrors(['code' => 'Akun ini nonaktif. Hubungi admin.'])
                ->onlyInput('code');
        }

        Auth::login($user, $request->boolean('remember'));
        $request->session()->regenerate();

        return redirect($this->panelPathForUser($user));
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

    protected function panelPathForUser(User $user): string
    {
        return match ($user->role) {
            'admin'   => '/admin',
            'guru'    => '/guru',
            'peserta' => '/peserta',
            default   => '/login',
        };
    }
}
