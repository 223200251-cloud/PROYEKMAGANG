<?php

namespace App\Http\Controllers;

use App\Models\Portfolio;
use App\Models\Comment;
use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PortfolioController extends Controller
{
    public function create()
    {
        return view('portfolio.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string|max:50',
            'image_url' => 'nullable|url',
            'project_url' => 'nullable|url',
            'technologies' => 'nullable|string',
        ]);

        $portfolio = Auth::user()->portfolios()->create($validated);

        return redirect()->route('portfolio.show', $portfolio)->with('success', 'Portfolio berhasil dibuat!');
    }

    public function edit(Portfolio $portfolio)
    {
        $this->authorize('update', $portfolio);
        return view('portfolio.edit', compact('portfolio'));
    }

    public function update(Request $request, Portfolio $portfolio)
    {
        $this->authorize('update', $portfolio);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string|max:50',
            'image_url' => 'nullable|url',
            'project_url' => 'nullable|url',
            'technologies' => 'nullable|string',
        ]);

        $portfolio->update($validated);

        return redirect()->route('portfolio.show', $portfolio)->with('success', 'Portfolio berhasil diupdate!');
    }

    public function destroy(Portfolio $portfolio)
    {
        $this->authorize('delete', $portfolio);
        $portfolio->delete();
        return redirect()->route('home')->with('success', 'Portfolio berhasil dihapus!');
    }

    public function addComment(Request $request, Portfolio $portfolio)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $validated = $request->validate([
            'comment' => 'required|string|max:1000',
        ]);

        Comment::create([
            'portfolio_id' => $portfolio->id,
            'user_id' => Auth::id(),
            'comment' => $validated['comment'],
        ]);

        $portfolio->increment('comments_count');

        return back()->with('success', 'Komentar berhasil ditambahkan!');
    }

    public function toggleLike(Request $request, Portfolio $portfolio)
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $like = Like::where('portfolio_id', $portfolio->id)
            ->where('user_id', Auth::id())
            ->first();

        if ($like) {
            $like->delete();
            $portfolio->decrement('likes_count');
            return response()->json(['liked' => false, 'likes_count' => $portfolio->likes_count]);
        } else {
            Like::create([
                'portfolio_id' => $portfolio->id,
                'user_id' => Auth::id(),
            ]);
            $portfolio->increment('likes_count');
            return response()->json(['liked' => true, 'likes_count' => $portfolio->likes_count]);
        }
    }

    // Portfolio Settings
    public function settings(Portfolio $portfolio)
    {
        $this->authorize('update', $portfolio);
        $userPortfolios = Auth::user()->portfolios()->orderBy('display_order')->get();
        return view('portfolio.settings', compact('portfolio', 'userPortfolios'));
    }

    public function updateSettings(Request $request, Portfolio $portfolio)
    {
        $this->authorize('update', $portfolio);

        $validated = $request->validate([
            'visibility' => 'required|in:public,private',
            'display_order' => 'required|integer|min:0',
            'is_highlighted' => 'nullable|boolean',
            'highlighted_until' => 'nullable|date_format:Y-m-d\TH:i|after:now',
        ]);

        // Reset highlight jika di-unchecked
        if (!$request->has('is_highlighted') || !$request->boolean('is_highlighted')) {
            $validated['is_highlighted'] = false;
            $validated['highlighted_until'] = null;
        }

        $portfolio->update($validated);

        return redirect()->route('portfolio.settings', $portfolio)->with('success', 'Pengaturan portfolio berhasil disimpan!');
    }

    public function reorderPortfolios(Request $request)
    {
        $validated = $request->validate([
            'order' => 'required|array',
            'order.*' => 'integer|exists:portfolios,id',
        ]);

        foreach ($validated['order'] as $index => $portfolioId) {
            Auth::user()->portfolios()->where('id', $portfolioId)->update(['display_order' => $index]);
        }

        return response()->json(['message' => 'Urutan portfolio berhasil diperbarui']);
    }
}
