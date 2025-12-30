<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::where('role', 'user')
            ->withCount('portfolios')
            ->paginate(15);

        return view('admin.users.index', compact('users'));
    }

    public function show(User $user)
    {
        $user->load('portfolios');
        $portfolios = $user->portfolios()->paginate(10);
        $totalViews = $user->portfolios()->sum('views');
        return view('admin.users.show', compact('user', 'portfolios', 'totalViews'));
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'username' => 'nullable|string|max:50|unique:users,username,' . $user->id,
            'avatar_url' => 'nullable|url',
            'role' => 'required|in:user,admin',
            'is_banned' => 'boolean',
        ]);

        $user->update($validated);

        return redirect()->route('admin.users.show', $user)
            ->with('success', 'User berhasil diupdate!');
    }

    public function destroy(User $user)
    {
        $user->portfolios()->delete();
        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil dihapus!');
    }

    public function toggleBan(User $user)
    {
        $user->is_banned = !$user->is_banned;
        $user->save();

        $status = $user->is_banned ? 'diblokir' : 'diaktifkan';
        return redirect()->back()->with('success', "User berhasil $status!");
    }
}
