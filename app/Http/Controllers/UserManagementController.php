<?php

namespace App\Http\Controllers;

use App\Models\Division;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Models\Role;

class UserManagementController extends Controller
{
    public function index()
    {
        $users = User::with(['division', 'roles'])->latest()->paginate(15);

        return view('users.index', compact('users'));
    }

    public function create()
    {
        $divisions = Division::all();

        return view('users.create', compact('divisions'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => ['required', 'string', 'max:255'],
            'email'       => ['required', 'email', 'unique:users,email'],
            'password'    => ['required', 'string', 'min:8'],
            'division_id' => ['required', 'exists:divisions,id'],
        ]);
        $access = $this->resolveAccess($data);

        $user = User::create([
            'name'        => $data['name'],
            'email'       => $data['email'],
            'password'    => Hash::make($data['password']),
            'division_id' => $access['division_id'],
        ]);

        $user->assignRole($access['role']);

        return redirect()->route('wm.users.index')->with('success', 'User berhasil dibuat.');
    }

    public function edit(User $user)
    {
        $divisions = Division::all();

        return view('users.edit', compact('user', 'divisions'));
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name'        => ['required', 'string', 'max:255'],
            'email'       => ['required', 'email', 'unique:users,email,' . $user->id],
            'password'    => ['nullable', 'string', 'min:8'],
            'division_id' => ['required', 'exists:divisions,id'],
        ]);
        $access = $this->resolveAccess($data);

        $user->update([
            'name'        => $data['name'],
            'email'       => $data['email'],
            'division_id' => $access['division_id'],
            ...(!empty($data['password']) ? ['password' => Hash::make($data['password'])] : []),
        ]);

        $user->syncRoles([$access['role']]);

        return redirect()->route('wm.users.index')->with('success', 'User berhasil diupdate.');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('wm.users.index')->with('success', 'User berhasil dihapus.');
    }

    private function resolveAccess(array $data): array
    {
        $division = isset($data['division_id'])
            ? Division::findOrFail($data['division_id'])
            : Division::where('slug', Str::replace('_', '-', $data['role']))->first();

        if (!$division) {
            throw ValidationException::withMessages([
                'role' => 'Role tersebut belum memiliki divisi yang sesuai.',
            ]);
        }

        $role = Str::replace('-', '_', $division->slug);

        if (isset($data['role']) && $data['role'] !== $role) {
            throw ValidationException::withMessages([
                'role' => 'Role dan divisi harus berasal dari pasangan yang sama.',
            ]);
        }

        if (!Role::where('name', $role)->where('guard_name', 'web')->exists()) {
            throw ValidationException::withMessages([
                'role' => 'Divisi tersebut belum memiliki role yang sesuai.',
            ]);
        }

        return ['division_id' => $division->id, 'role' => $role];
    }
}
