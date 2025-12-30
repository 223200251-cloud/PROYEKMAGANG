<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Portfolio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    // Tampilkan profil user (public)
    public function show(User $user)
    {
        $portfolios = $user->portfolios()
            ->where('visibility', 'public')
            ->orderBy('display_order')
            ->paginate(6);
        
        $stats = [
            'total_portfolios' => $user->portfolios()->where('visibility', 'public')->count(),
            'total_views' => $user->portfolios()->where('visibility', 'public')->sum('views'),
            'total_likes' => $user->portfolios()->where('visibility', 'public')->sum('likes_count'),
            'total_comments' => $user->portfolios()->where('visibility', 'public')->sum('comments_count'),
        ];
        
        return view('profile.show', compact('user', 'portfolios', 'stats'));
    }

    // Edit profil user (auth)
    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    // Update profil user
    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'username' => 'nullable|string|max:50|unique:users,username,' . $user->id,
            'bio' => 'nullable|string|max:500',
            'avatar_url' => 'nullable|url',
            'website' => 'nullable|url',
            'location' => 'nullable|string|max:100',
            'phone' => 'nullable|string|max:20',
        ]);

        $user->update($validated);

        return redirect()->route('profile.my-profile')->with('success', 'Profil berhasil diperbarui!');
    }

    // Tampilkan halaman profil saya
    public function myProfile()
    {
        $user = Auth::user();
        $portfolios = $user->portfolios()->paginate(6);
        $stats = [
            'total_portfolios' => $user->portfolios()->count(),
            'total_views' => $user->portfolios()->sum('views'),
            'total_likes' => $user->portfolios()->sum('likes_count'),
            'total_comments' => $user->portfolios()->sum('comments_count'),
        ];
        
        return view('profile.my-profile', compact('user', 'portfolios', 'stats'));
    }
}
