<?php

namespace App\Http\Controllers;

use App\Models\Division;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
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
        $roles = Role::all();
        $divisions = Division::all();

        return view('users.create', compact('roles', 'divisions'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => ['required', 'string', 'max:255'],
            'email'       => ['required', 'email', 'unique:users,email'],
            'password'    => ['required', 'string', 'min:8'],
            'division_id' => ['required', 'exists:divisions,id'],
            'role'        => ['required', 'exists:roles,name'],
        ]);

        $user = User::create([
            'name'        => $data['name'],
            'email'       => $data['email'],
            'password'    => Hash::make($data['password']),
            'division_id' => $data['division_id'],
        ]);

        $user->assignRole($data['role']);

        return redirect()->route('wm.users.index')->with('success', 'User berhasil dibuat.');
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        $divisions = Division::all();

        return view('users.edit', compact('user', 'roles', 'divisions'));
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name'        => ['required', 'string', 'max:255'],
            'email'       => ['required', 'email', 'unique:users,email,' . $user->id],
            'password'    => ['nullable', 'string', 'min:8'],
            'division_id' => ['required', 'exists:divisions,id'],
            'role'        => ['required', 'exists:roles,name'],
        ]);

        $user->update([
            'name'        => $data['name'],
            'email'       => $data['email'],
            'division_id' => $data['division_id'],
            ...(!empty($data['password']) ? ['password' => Hash::make($data['password'])] : []),
        ]);

        $user->syncRoles([$data['role']]);

        return redirect()->route('wm.users.index')->with('success', 'User berhasil diupdate.');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('wm.users.index')->with('success', 'User berhasil dihapus.');
    }
}
