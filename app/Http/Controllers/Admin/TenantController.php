<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use App\Models\Room;
use App\Http\Requests\StoreTenantRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TenantController extends Controller
{
    public function index(Request $request)
    {
        $query = Tenant::with('room');

        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $tenants = $query->latest()->paginate(10);
        return view('admin.tenants.index', compact('tenants'));
    }

    public function create()
    {
        // Hanya tampilkan kamar yang statusnya available
        $rooms = Room::where('status', 'available')->get();
        return view('admin.tenants.create', compact('rooms'));
    }

    public function store(StoreTenantRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('id_card_photo')) {
            $data['id_card_photo'] = $request->file('id_card_photo')->store('tenants', 'public');
        }

        // Model Booted akan otomatis menghitung due_date dan mengupdate status kamar menjadi 'occupied'
        $tenant = Tenant::create($data);

        app(\App\Services\PaymentService::class)->createInitialPayment($tenant);

        activity_log('create_tenant', $tenant, 'Menambahkan penghuni baru: ' . $tenant->name);

        return redirect()->route('admin.tenants.index')->with('success', 'Penghuni berhasil ditambahkan.');
    }

    public function show(Tenant $tenant)
    {
        $tenant->load(['room', 'payments' => function($query) {
            $query->orderBy('created_at', 'desc');
        }]);
        return view('admin.tenants.show', compact('tenant'));
    }

    public function edit(Tenant $tenant)
    {
        return view('admin.tenants.edit', compact('tenant'));
    }

    public function update(StoreTenantRequest $request, Tenant $tenant)
    {
        $data = $request->validated();

        if ($request->hasFile('id_card_photo')) {
            if ($tenant->id_card_photo) {
                Storage::disk('public')->delete($tenant->id_card_photo);
            }
            $data['id_card_photo'] = $request->file('id_card_photo')->store('tenants', 'public');
        }

        $tenant->update($data);
        activity_log('update_tenant', $tenant, 'Memperbarui data penghuni: ' . $tenant->name);

        return redirect()->route('admin.tenants.index')->with('success', 'Data penghuni berhasil diperbarui.');
    }

    public function destroy(Tenant $tenant)
    {
        // Penghuni sebaiknya tidak dihapus sembarangan untuk riwayat, disarankan menggunakan fitur Alumni
        // Namun kita tetap sediakan untuk super_admin jika diperlukan
        if ($tenant->id_card_photo) {
            Storage::disk('public')->delete($tenant->id_card_photo);
        }

        $name = $tenant->name;
        $tenant->delete(); // Ini akan memicu event 'deleted' (jika Anda menambahkannya) atau Anda bisa panggil updateStatus manual
        $tenant->room->updateStatus();

        activity_log('delete_tenant', null, 'Menghapus data penghuni: ' . $name);

        return redirect()->route('admin.tenants.index')->with('success', 'Penghuni berhasil dihapus.');
    }

    public function setAlumni(Tenant $tenant)
    {
        $tenant->update(['status' => 'alumni']);
        // Model Booted 'saved' otomatis akan mengubah status kamar kembali ke 'available'

        activity_log('set_alumni', $tenant, 'Mengubah status penghuni menjadi alumni: ' . $tenant->name);

        return redirect()->route('admin.tenants.index')->with('success', 'Penghuni berhasil diubah menjadi alumni. Kamar sekarang tersedia.');
    }
}
