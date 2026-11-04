<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function create(): View
    {
        return view('auth.login');
    }

    public function store(Request $request): RedirectResponse
    {
        $credentials = $request->validate(['email' => ['required', 'email'], 'password' => ['required']]);
        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()->withErrors(['email' => 'Las credenciales no coinciden con nuestros registros.'])->onlyInput('email');
        } $request->session()->regenerate();

        return redirect()->intended(route('inicio'));
    }

    public function register(): View
    {
        return view('auth.register');
    }

    public function registerStore(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users'],
            'recovery_email' => ['nullable', 'email', 'max:255', 'different:email', Rule::unique('users', 'recovery_email')],
            'password' => ['required', 'confirmed', 'min:8'],
            'terms_accepted' => ['accepted'],
        ]);
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'recovery_email' => $data['recovery_email'],
            'password' => Hash::make($data['password']),
            'role_id' => Role::general()->id,
            'terms_accepted' => true,
            'terms_accepted_at' => now(),
        ]);
        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('inicio');
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
