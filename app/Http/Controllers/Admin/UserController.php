<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->paginate(10);

        return view('admin.users.index', ['users' => $users]);
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(StoreUserRequest $request)
    {
        $validated = $request->validated();

        if (auth()->user()->role === 'admin' && in_array($validated['role'], ['admin', 'superadmin'])) {
            return back()->withErrors(['role' => 'Admin hanya dapat membuat akun Panitia.']);
        }

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'] ?? null,
            'password' => Hash::make($validated['password']),
            'phone' => $validated['phone'] ?? null,
            'role' => $validated['role'],
            'status' => $validated['status'],
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User berhasil dibuat.');
    }

    public function edit(User $user)
    {
        if (auth()->user()->role === 'admin' && in_array($user->role, ['admin', 'superadmin'])) {
            return back()->with('error', 'Anda tidak memiliki hak akses untuk mengedit akun ini.');
        }

        return view('admin.users.edit', ['user' => $user]);
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        if (auth()->user()->role === 'admin' && in_array($user->role, ['admin', 'superadmin'])) {
            return back()->with('error', 'Anda tidak memiliki hak akses untuk mengedit akun ini.');
        }

        $validated = $request->validated();
        if (auth()->user()->role === 'admin' && isset($validated['role']) && in_array($validated['role'], ['admin', 'superadmin'])) {
            return back()->withErrors(['role' => 'Anda tidak bisa mengubah role menjadi Admin/Super Admin.']);
        }

        $user->update($validated);

        return redirect()->route('admin.users.index')->with('success', 'User berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        if (auth()->id() === $user->id) {
            return back()->withErrors([
                'general' => 'Akun yang sedang digunakan tidak dapat dihapus.',
            ]);
        }

        if (auth()->user()->role === 'admin' && in_array($user->role, ['admin', 'superadmin'])) {
            return back()->with('error', 'Anda tidak memiliki hak akses untuk menghapus akun ini.');
        }

        $user->delete();

        return back()->with('success', 'User berhasil dihapus.');
    }
}
