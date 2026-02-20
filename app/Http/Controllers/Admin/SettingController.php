<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class SettingController extends Controller
{
    public function index()
    {
        return view('admin.settings.index');
    }

    public function update(Request $request)
    {
        $request->validate([
            'kost_name' => 'required|string|max:100',
            'kost_address' => 'required|string',
            'admin_phone' => 'required|string',
            'penalty_per_day' => 'required|numeric|min:0',
        ]);

        $this->setEnvValue('KOST_NAME', $request->kost_name);
        $this->setEnvValue('KOST_ADDRESS', $request->kost_address);
        $this->setEnvValue('ADMIN_PHONE', $request->admin_phone);
        $this->setEnvValue('PENALTY_PER_DAY', $request->penalty_per_day);

        // Hapus cache agar nilai .env yang baru langsung terbaca oleh sistem
        Artisan::call('config:clear');

        // Catat ke log aktivitas
        activity_log('update_settings', null, 'Memperbarui pengaturan identitas dan denda sistem kost');

        return back()->with('success', 'Pengaturan sistem berhasil diperbarui.');
    }

    /**
     * Fungsi bantuan untuk mengubah nilai di file .env
     */
    private function setEnvValue($key, $value)
    {
        $path = app()->environmentFilePath();
        $env = file_get_contents($path);

        // Bungkus nilai dengan tanda kutip jika mengandung spasi
        $escapedValue = preg_match('/\s/', $value) ? '"' . $value . '"' : $value;

        // Cek apakah key sudah ada di .env
        if (str_contains($env, $key . '=')) {
            // Timpa nilai lama dengan nilai baru
            $env = preg_replace('/^' . $key . '=.*/m', $key . '=' . $escapedValue, $env);
        } else {
            // Tambahkan di baris baru jika key belum ada
            $env .= "\n" . $key . '=' . $escapedValue;
        }

        file_put_contents($path, $env);
    }
}
