<?php

namespace App\Http\Controllers;

use App\Models\Idea;
use App\Models\User;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'totalUsers' => User::count(),
            'totalIdeas' => Idea::count(),
            'pendingIdeas' => Idea::where('status', 'pending')->count(),
            'recentIdeas' => Idea::latest()->take(5)->get(),
            'recentUsers' => User::latest()->take(5)->get(),
        ]);
    }
}
