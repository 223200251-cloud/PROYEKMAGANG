<?php

namespace App\Http\Controllers;

use App\Models\Portfolio;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('q');
        
        if ($search) {
            // Search in portfolios dan users, filter by visibility
            $portfolios = Portfolio::with(['user', 'comments', 'likes'])
                ->where('visibility', 'public')
                ->where(function($query) use ($search) {
                    $query->where('title', 'LIKE', "%{$search}%")
                        ->orWhere('description', 'LIKE', "%{$search}%")
                        ->orWhereHas('user', function($q) use ($search) {
                            $q->where('name', 'LIKE', "%{$search}%")
                                ->orWhere('username', 'LIKE', "%{$search}%");
                        });
                })
                ->orderByRaw('is_highlighted DESC, display_order ASC, created_at DESC')
                ->paginate(6)
                ->appends($request->query());
        } else {
            // Ambil portfolio publik, prioritaskan highlighted, urutkan by display_order
            $portfolios = Portfolio::with(['user', 'comments', 'likes'])
                ->where('visibility', 'public')
                ->where(function($query) {
                    $query->where('is_highlighted', false)
                        ->orWhere(function($q) {
                            // Highlight yang masih aktif (belum expired)
                            $q->where('is_highlighted', true)
                                ->where(function($w) {
                                    $w->whereNull('highlighted_until')
                                        ->orWhereRaw('highlighted_until > NOW()');
                                });
                        });
                })
                ->orderByRaw('is_highlighted DESC, display_order ASC, created_at DESC')
                ->paginate(6);
        }

        return view('home', compact('portfolios', 'search'));
    }

    public function show(Portfolio $portfolio)
    {
        // Increment views
        $portfolio->increment('views');

        $portfolio->load(['user', 'comments.user', 'likes']);
        
        return view('portfolio.show', compact('portfolio'));
    }
}
