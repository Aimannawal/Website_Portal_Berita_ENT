<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Artikel;
use App\Models\Berita;
use App\Models\Task;

class PkDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_berita'  => Berita::count(),
            'total_artikel' => Artikel::count(),
            'task_pending'  => Task::where('status', 'pending')->count(),
            'task_progress' => Task::where('status', 'in_progress')->count(),
            'task_done'     => Task::where('status', 'done')->count(),
        ];

        $recentTasks = Task::with(['division', 'assignedUser'])
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard.pk.index', compact('stats', 'recentTasks'));
    }
}
