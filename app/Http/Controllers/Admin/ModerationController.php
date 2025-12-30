<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Portfolio;
use Illuminate\Http\Request;

class ModerationController extends Controller
{
    public function index()
    {
        $portfolios = Portfolio::with(['user', 'comments'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        $stats = [
            'total_portfolios' => Portfolio::count(),
            'total_flagged' => Portfolio::where('is_flagged', true)->count(),
            'total_rejected' => Portfolio::where('status', 'rejected')->count(),
        ];

        return view('admin.moderation.index', compact('portfolios', 'stats'));
    }

    public function show(Portfolio $portfolio)
    {
        $portfolio->load(['user', 'comments.user', 'likes']);
        return view('admin.moderation.show', compact('portfolio'));
    }

    public function flag(Portfolio $portfolio)
    {
        $portfolio->is_flagged = true;
        $portfolio->save();

        return redirect()->back()->with('success', 'Portfolio di-flag untuk review!');
    }

    public function unflag(Portfolio $portfolio)
    {
        $portfolio->is_flagged = false;
        $portfolio->save();

        return redirect()->back()->with('success', 'Portfolio unflag!');
    }

    public function reject(Request $request, Portfolio $portfolio)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:500',
        ]);

        $portfolio->status = 'rejected';
        $portfolio->rejection_reason = $request->rejection_reason;
        $portfolio->save();

        return redirect()->back()->with('success', 'Portfolio berhasil ditolak!');
    }

    public function approve(Portfolio $portfolio)
    {
        $portfolio->status = 'approved';
        $portfolio->is_flagged = false;
        $portfolio->save();

        return redirect()->route('admin.moderation.index')
            ->with('success', 'Portfolio berhasil disetujui!');
    }

    public function destroy(Portfolio $portfolio)
    {
        $portfolio->delete();

        return redirect()->route('admin.moderation.index')
            ->with('success', 'Portfolio berhasil dihapus!');
    }
}
