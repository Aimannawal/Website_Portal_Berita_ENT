<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class DivisiDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $tasks = Task::where('assigned_to_division', $user->division_id)
            ->where(function ($q) use ($user) {
                $q->whereNull('assigned_to_user')
                    ->orWhere('assigned_to_user', $user->id);
            })
            ->latest()
            ->take(10)
            ->get();

        $summary = [
            'pending'     => $tasks->where('status', 'pending')->count(),
            'in_progress' => $tasks->where('status', 'in_progress')->count(),
            'done'        => $tasks->where('status', 'done')->count(),
        ];

        return view('dashboard.divisi.index', compact('tasks', 'summary'));
    }
}
