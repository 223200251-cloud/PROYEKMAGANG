<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Portfolio;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users' => User::where('role', 'user')->count(),
            'total_portfolios' => Portfolio::count(),
            'total_categories' => Category::where('is_active', true)->count(),
            'pending_moderation' => 0, // TODO: Implementasi fitur moderation
        ];

        $recent_portfolios = Portfolio::with('user')
            ->latest()
            ->limit(10)
            ->get();

        return view('admin.dashboard', compact('stats', 'recent_portfolios'));
    }
}
