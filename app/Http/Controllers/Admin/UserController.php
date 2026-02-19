<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        $users = User::paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|string|email|max:150|unique:users',
            'password' => 'required|string|min:8',
            'role' => ['required', Rule::in(['super_admin', 'owner', 'admin'])],
        ]);

        // Proteksi: Owner hanya boleh membuat akun Admin
        if (auth()->user()->role === 'owner' && $request->role !== 'admin') {
            return back()->with('error', 'Owner hanya dapat membuat akun Admin.');
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'is_active' => $request->has('is_active'),
        ]);

        activity_log('create_user', $user, 'Menambahkan pengguna baru: ' . $user->name);

        return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|string|email|max:150|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8',
            'role' => ['required', Rule::in(['super_admin', 'owner', 'admin'])],
        ]);

        // Proteksi role
        if (auth()->user()->role === 'owner' && $request->role !== 'admin' && $user->role !== auth()->user()->role) {
            return back()->with('error', 'Anda tidak memiliki izin untuk menetapkan role ini.');
        }

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'is_active' => $request->has('is_active'),
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);
        activity_log('update_user', $user, 'Memperbarui data pengguna: ' . $user->name);

        return redirect()->route('admin.users.index')->with('success', 'Data pengguna berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        if ($user->role === 'super_admin') {
            return back()->with('error', 'Akun Super Admin tidak dapat dihapus.');
        }

        $name = $user->name;
        $user->delete();

        activity_log('delete_user', null, 'Menghapus pengguna: ' . $name);

        return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil dihapus.');
    }
}
