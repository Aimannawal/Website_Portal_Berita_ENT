<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Artikel;
use App\Models\Berita;
use App\Models\Task;
use App\Models\User;

class WmDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users'        => User::count(),
            'total_berita'       => Berita::count(),
            'total_artikel'      => Artikel::count(),
            'total_task_pending' => Task::where('status', 'pending')->count(),
        ];

        return view('dashboard.wm.index', compact('stats'));
    }
}
