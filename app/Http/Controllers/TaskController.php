<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use App\Models\Berita;
use App\Models\Division;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    // ---- dipakai PK ----

    public function index()
    {
        $tasks = Task::with(['division', 'assignedUser', 'assignedBy', 'berita', 'artikel'])
            ->latest()
            ->paginate(15);

        return view('tasks.index', compact('tasks'));
    }

    public function create()
    {
        // divisi pelaksana saja (bukan webmaster/PK) yang bisa jadi tujuan task
        $divisions = Division::whereNotIn('slug', ['webmaster', 'perencanaan-konten'])->get();
        $berita = Berita::latest()->take(50)->get();
        $artikel = Artikel::latest()->take(50)->get();

        return view('tasks.create', compact('divisions', 'berita', 'artikel'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'                => ['required', 'string', 'max:255'],
            'description'          => ['nullable', 'string'],
            'assigned_to_division' => ['required', 'exists:divisions,id'],
            'assigned_to_user'     => ['nullable', 'exists:users,id'],
            'berita_id'            => ['nullable', 'exists:berita,id'],
            'artikel_id'           => ['nullable', 'exists:artikel,id'],
            'deadline'             => ['nullable', 'date'],
        ]);

        Task::create([
            ...$data,
            'assigned_by' => Auth::id(),
            'status'      => 'pending',
        ]);

        return redirect()->route('pk.tasks.index')->with('success', 'Task berhasil di-assign.');
    }

    public function show(Task $task)
    {
        $task->load(['division', 'assignedUser', 'assignedBy', 'berita', 'artikel']);

        return view('tasks.show', compact('task'));
    }

    // ---- dipakai divisi pelaksana ----

    public function myTasks()
    {
        $user = Auth::user();

        $tasks = Task::where('assigned_to_division', $user->division_id)
            ->where(function ($q) use ($user) {
                $q->whereNull('assigned_to_user')->orWhere('assigned_to_user', $user->id);
            })
            ->latest()
            ->paginate(15);

        return view('divisi.tasks.index', compact('tasks'));
    }

    public function updateStatus(Request $request, Task $task)
    {
        $user = Auth::user();

        // penting: cegah user divisi lain update task yang bukan miliknya
        abort_if($task->assigned_to_division !== $user->division_id, 403);

        $data = $request->validate([
            'status' => ['required', 'in:in_progress,done'],
            'notes'  => ['nullable', 'string'],
        ]);

        $task->update($data);

        return back()->with('success', 'Status task berhasil diupdate.');
    }
}
