<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'username' => 'required|string|unique:users,username|max:50',
            'password' => 'required|string|min:8|confirmed',
            'user_type' => 'required|in:individual,company',
            'company_name' => 'nullable|required_if:user_type,company|string|max:255',
            'company_website' => 'nullable|required_if:user_type,company|url',
            'company_phone' => 'nullable|required_if:user_type,company|string|max:20',
            'company_description' => 'nullable|string|max:1000',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'username' => $validated['username'],
            'password' => Hash::make($validated['password']),
            'user_type' => $validated['user_type'],
            'company_name' => $validated['company_name'] ?? null,
            'company_website' => $validated['company_website'] ?? null,
            'company_phone' => $validated['company_phone'] ?? null,
            'company_description' => $validated['company_description'] ?? null,
        ]);

        Auth::login($user);
        return redirect()->route('home')->with('success', 'Akun berhasil dibuat!');
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:8',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('home')->with('success', 'Login berhasil!');
        }

        return back()->withErrors(['email' => 'Email atau password salah'])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home')->with('success', 'Logout berhasil!');
    }
}
