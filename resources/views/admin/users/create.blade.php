@extends('layouts.admin')
@section('title', 'Tambah Pengguna')
@section('header', 'Tambah Pengguna Baru')

@section('content')
<div class="bg-white p-6 rounded shadow max-w-lg">
    <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-4">
        @csrf
        <div>
            <label class="block text-gray-700">Nama Lengkap</label>
            <input type="text" name="name" required class="w-full border-gray-300 rounded mt-1">
        </div>
        <div>
            <label class="block text-gray-700">Email</label>
            <input type="email" name="email" required class="w-full border-gray-300 rounded mt-1">
        </div>
        <div>
            <label class="block text-gray-700">Password</label>
            <input type="password" name="password" required class="w-full border-gray-300 rounded mt-1">
        </div>
        <div>
            <label class="block text-gray-700">Role</label>
            <select name="role" required class="w-full border-gray-300 rounded mt-1">
                @if(auth()->user()->role === 'super_admin')
                    <option value="super_admin">Super Admin</option>
                    <option value="owner">Owner</option>
                @endif
                <option value="admin" selected>Admin</option>
            </select>
        </div>
        <div class="mt-4">
            <label class="inline-flex items-center">
                <input type="checkbox" name="is_active" value="1" checked class="rounded border-gray-300 text-blue-600">
                <span class="ml-2">Akun Aktif</span>
            </label>
        </div>
        <div class="flex justify-end space-x-2 pt-4">
            <a href="{{ route('admin.users.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Batal</a>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Simpan Pengguna</button>
        </div>
    </form>
</div>
@endsection
