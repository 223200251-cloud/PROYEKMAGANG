<?php

namespace App\Http\Controllers;

use App\Models\Portfolio;
use App\Models\Comment;
use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PortfolioController extends Controller
{
    public function create()
    {
        // Hanya kreator (individual) yang bisa membuat portfolio
        if (Auth::user()->user_type !== 'individual') {
            return redirect()->route('home')->with('error', 'Hanya kreator yang dapat membuat portfolio. Recruiter hanya bisa melihat dan menyimpan kandidat.');
        }
        
        $this->authorize('create', Portfolio::class);
        
        return view('portfolio.create');
    }

    public function store(Request $request)
    {
        // Hanya kreator yang bisa upload portfolio
        if (Auth::user()->user_type !== 'individual') {
            return redirect()->route('home')->with('error', 'Hanya kreator yang dapat membuat portfolio.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string|max:50',
            'image_type' => 'required|in:uploaded,url',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'image_url' => 'nullable|url',
            'project_url' => 'nullable|url',
            'technologies' => 'nullable|string',
        ]);

        // Validasi: salah satu image_file atau image_url harus ada
        if ($validated['image_type'] === 'uploaded' && !$request->hasFile('image_file')) {
            return redirect()->back()->withErrors(['image_file' => 'File foto harus diunggah'])->withInput();
        }

        if ($validated['image_type'] === 'url' && empty($validated['image_url'])) {
            return redirect()->back()->withErrors(['image_url' => 'URL gambar harus diisi'])->withInput();
        }

        $portfolioData = [
            'title' => $validated['title'],
            'description' => $validated['description'],
            'category' => $validated['category'],
            'project_url' => $validated['project_url'],
            'technologies' => $validated['technologies'],
            'image_type' => $validated['image_type'],
        ];

        // Handle image upload
        if ($validated['image_type'] === 'uploaded' && $request->hasFile('image_file')) {
            $path = $request->file('image_file')->store('portfolios', 'public');
            $portfolioData['image_path'] = $path;
            $portfolioData['image_url'] = null;
        } else {
            $portfolioData['image_url'] = $validated['image_url'];
            $portfolioData['image_path'] = null;
        }

        $portfolio = Auth::user()->portfolios()->create($portfolioData);

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
            'image_type' => 'nullable|in:uploaded,url',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'image_url' => 'nullable|url',
            'project_url' => 'nullable|url',
            'technologies' => 'nullable|string',
        ]);

        $portfolioData = [
            'title' => $validated['title'],
            'description' => $validated['description'],
            'category' => $validated['category'],
            'project_url' => $validated['project_url'],
            'technologies' => $validated['technologies'],
        ];

        // Handle image update jika ada perubahan tipe image
        if ($validated['image_type']) {
            $portfolioData['image_type'] = $validated['image_type'];

            if ($validated['image_type'] === 'uploaded' && $request->hasFile('image_file')) {
                // Hapus file lama jika ada
                if ($portfolio->image_type === 'uploaded' && $portfolio->image_path) {
                    Storage::disk('public')->delete($portfolio->image_path);
                }

                $path = $request->file('image_file')->store('portfolios', 'public');
                $portfolioData['image_path'] = $path;
                $portfolioData['image_url'] = null;
            } elseif ($validated['image_type'] === 'url' && !empty($validated['image_url'])) {
                // Hapus file lama jika ada
                if ($portfolio->image_type === 'uploaded' && $portfolio->image_path) {
                    Storage::disk('public')->delete($portfolio->image_path);
                }

                $portfolioData['image_url'] = $validated['image_url'];
                $portfolioData['image_path'] = null;
            }
        }

        $portfolio->update($portfolioData);

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

        $currentUser = Auth::user();

        // Cek apakah user adalah kreator (individual)
        if ($currentUser->user_type === 'individual') {
            return back()->with('error', 'Kreator tidak diizinkan membuat komentar');
        }

        // Cek authorization menggunakan policy
        $this->authorize('create', Comment::class);

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
