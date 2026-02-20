<div align="center">

# 🏠 KOST-MANAJEMEN

### Smart Boarding House Management System

[![Laravel](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.3+-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://php.net)
[![MySQL](https://img.shields.io/badge/MySQL-8.0+-4479A1?style=for-the-badge&logo=mysql&logoColor=white)](https://mysql.com)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-3.x-06B6D4?style=for-the-badge&logo=tailwindcss&logoColor=white)](https://tailwindcss.com)
[![License](https://img.shields.io/badge/License-MIT-green?style=for-the-badge)](LICENSE)

**Sistem manajemen kost modern yang terpusat, otomatis, dan scalable.**  
Dirancang dengan prinsip _clean architecture_ — admin cukup input data, semua perhitungan berjalan otomatis.

[📋 Fitur Utama](#-fitur-utama) · [⚙️ Instalasi](#️-instalasi) · [🗄️ Database](#️-struktur-database) · [🚀 Penggunaan](#-penggunaan) · [📁 Struktur Folder](#-struktur-folder)

---

</div>

## 📌 Tentang Sistem

**KOST-MANAJEMEN** adalah sistem manajemen kost berbasis web yang mengelola kamar, penghuni, dan pembayaran secara otomatis. Dibangun di atas **Laravel 12** dengan arsitektur yang bersih dan scalable, sistem ini siap dikembangkan menjadi produk SaaS multi-kost.

### Filosofi Utama

> Admin **hanya** menginput data awal dan mengkonfirmasi pembayaran.  
> Semua kalkulasi, perubahan status, dan pembuatan record berjalan **otomatis**.

- ✅ **Tidak ada perhitungan manual** — denda, jatuh tempo, dan perpanjangan sewa dihitung otomatis
- ✅ **Tidak ada payment gateway** — pembayaran dicatat manual oleh admin
- ✅ **WhatsApp gratis** — menggunakan `wa.me` redirect, tanpa API berbayar
- ✅ **Status kamar otomatis** — berubah `available ↔ occupied` berdasarkan data penghuni aktif

---

## ✨ Fitur Utama

### 🌐 Landing Page Publik (Tanpa Login)
- Profil kost, fasilitas umum, dan galeri foto kamar
- Filter kamar berdasarkan tipe: **VVIP / VIP / Reguler**
- Status kamar **realtime** dari database (Tersedia / Penuh)
- Tombol **"Tanya via WhatsApp"** — redirect ke `wa.me` dengan pesan otomatis per kamar

### 📊 Dashboard Admin
- **7 stat card** realtime: total kamar, kamar terisi, penghuni aktif, pemasukan, pengeluaran, laba bersih
- **Grafik keuangan** 6 bulan terakhir (Chart.js — Bar Chart pemasukan vs pengeluaran)
- Tabel **jatuh tempo terdekat** (7 hari ke depan, berwarna sesuai urgency)
- Tabel **penghuni overdue** (sudah melewati jatuh tempo)

### 🛏️ Manajemen Kamar
- CRUD kamar dengan upload foto (multiple)
- Tipe kamar: VVIP, VIP, Reguler
- Fasilitas kamar (checkbox multi-select: AC, WiFi, Kamar Mandi Dalam, dll)
- Status kamar **berubah otomatis** — tidak bisa diubah manual

### 👥 Manajemen Penghuni
- Form pendaftaran penghuni dengan upload foto KTP
- **`due_date` dihitung otomatis** dari `check_in_date + rent_duration`
- **Payment pertama dibuat otomatis** saat penghuni ditambah
- Fitur "Jadikan Alumni" → kamar otomatis kembali tersedia
- Histori pembayaran lengkap per penghuni

### 💰 Sistem Pembayaran
- Konfirmasi pembayaran oleh admin (tanpa payment gateway)
- **Denda otomatis**: Rp 5.000/hari × hari keterlambatan
- **Perpanjangan sewa otomatis** setelah pembayaran dikonfirmasi
- **Payment berikutnya dibuat otomatis** setelah konfirmasi
- **Generate invoice PDF** — format profesional siap cetak

### 📱 Reminder WhatsApp (Free — wa.me Redirect)
| Kategori | Kapan Tampil | Warna |
|----------|-------------|-------|
| H-7 | 7 hari sebelum jatuh tempo | 🔵 Biru |
| H-3 | 3 hari sebelum jatuh tempo | 🟡 Kuning |
| H-0 | Tepat hari jatuh tempo | 🟠 Oranye |
| Overdue | Sudah melewati jatuh tempo | 🔴 Merah |

Pesan reminder di-**generate otomatis** per kategori. Admin cukup klik tombol → browser buka WhatsApp dengan pesan terisi.

### 📈 Laporan Keuangan
- Laporan **bulanan** (filter bulan & tahun) — tabel pemasukan + pengeluaran + laba bersih
- Laporan **tahunan** — grafik Bar Chart 12 bulan
- Export **PDF** dan **CSV**

### 🔐 Keamanan & Role
| Role | Akses |
|------|-------|
| **Super Admin** | Semua fitur + User Management + Activity Log |
| **Admin** | Kamar, Penghuni, Pembayaran, Pengeluaran, Reminder, Laporan |

---

## ⚙️ Instalasi

### Prasyarat

Pastikan sudah terinstall:
- PHP >= 8.2
- Composer
- MySQL >= 8.0
- Node.js & NPM

### Langkah Instalasi

**1. Clone repository**
```bash
git clone https://github.com/username/kost-manajemen.git
cd kost-manajemen
```

**2. Install dependency PHP**
```bash
composer install
```

**3. Salin file environment**
```bash
cp .env.example .env
php artisan key:generate
```

**4. Konfigurasi `.env`**
```env
APP_NAME=KOST-MANAJEMEN
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=kost_manajemen
DB_USERNAME=root
DB_PASSWORD=

# Konfigurasi Kost
KOST_NAME="Kost Sejahtera"
KOST_ADDRESS="Jl. Contoh No. 1, Kota"
ADMIN_PHONE=6281234567890       # Format: 628xxx (tanpa + atau 0)
PENALTY_PER_DAY=5000             # Denda per hari dalam Rupiah
```

**5. Buat database & jalankan migrasi**
```bash
# Buat database di MySQL
mysql -u root -p -e "CREATE DATABASE kost_manajemen CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"

# Jalankan migrasi + seeder
php artisan migrate --seed
```

**6. Install dependency frontend**
```bash
npm install && npm run build
```

**7. Buat symlink storage (untuk foto kamar & KTP)**
```bash
php artisan storage:link
```

**8. Jalankan server**
```bash
php artisan serve
```

Buka di browser: **http://localhost:8000**

---

## 🔑 Akun Default (Seeder)

| Role | Email | Password |
|------|-------|----------|
| Super Admin | `super_admin@kost.com` | `password` |
| Admin | `admin@kost.com` | `password` |

> ⚠️ **Ganti password setelah pertama login di production!**

---

## 🗄️ Struktur Database

Sistem menggunakan **7 tabel utama**:

```
users               → Akun pengguna sistem (Super Admin, Owner, Admin)
rooms               → Data kamar kost
tenants             → Data penghuni kost
payments            → Tagihan & transaksi pembayaran sewa
expenses            → Pengeluaran operasional kost
reminder_logs       → Riwayat reminder WhatsApp yang sudah dikirim
activity_logs       → Audit trail semua aktivitas sistem
```

### Relasi Utama

```
rooms     ──< tenants    (1 kamar → banyak penghuni [histori])
tenants   ──< payments   (1 penghuni → banyak tagihan)
tenants   ──< reminder_logs
users     ──< activity_logs
```

---

## 🔄 Logika Otomatis

Semua proses berikut berjalan **tanpa intervensi admin**:

| Trigger | Aksi Otomatis |
|---------|--------------|
| Penghuni ditambah | `due_date` dihitung, status kamar → `occupied`, payment pertama dibuat |
| Pembayaran dikonfirmasi | Denda dihitung, `due_date` diperpanjang, payment berikutnya dibuat |
| Penghuni dijadikan alumni | Status kamar → `available` |
| Laporan dibuka | Semua angka dihitung realtime dari database |
| Landing page diakses | Status kamar tampil sesuai data aktif |

---

## 📁 Struktur Folder

```
kost-manajemen/
├── app/
│   ├── Console/
│   │   └── Commands/
│   │       ├── SendPaymentReminders.php   # php artisan reminders:notify
│   │       └── UpdateRoomStatus.php       # php artisan rooms:sync-status
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/
│   │   │   │   ├── DashboardController.php
│   │   │   │   ├── RoomController.php
│   │   │   │   ├── TenantController.php
│   │   │   │   ├── PaymentController.php
│   │   │   │   ├── ExpenseController.php
│   │   │   │   ├── ReminderController.php
│   │   │   │   ├── ReportController.php
│   │   │   │   ├── ActivityLogController.php
│   │   │   │   ├── SettingController.php
│   │   │   │   └── UserController.php
│   │   │   └── PublicController.php
│   │   ├── Middleware/
│   │   │   └── RoleMiddleware.php
│   │   └── Requests/
│   │       ├── StoreRoomRequest.php
│   │       └── StoreTenantRequest.php
│   ├── Models/
│   │   ├── User.php
│   │   ├── Room.php          # updateStatus(), activeTenant()
│   │   ├── Tenant.php        # Booted: auto due_date, auto room status
│   │   ├── Payment.php
│   │   ├── Expense.php
│   │   ├── ReminderLog.php
│   │   └── ActivityLog.php
│   ├── Services/
│   │   ├── PaymentService.php    # Kalkulasi denda, perpanjangan, invoice number
│   │   └── ReminderService.php   # Generate WA URL, template pesan, log reminder
│   └── helpers.php               # activity_log() helper function
├── database/
│   ├── migrations/               # 7 tabel + indexes
│   └── seeders/                  # User, Room, Tenant, Payment, Expense
├── resources/views/
│   ├── layouts/
│   │   └── admin.blade.php       # Layout sidebar Tailwind
│   ├── admin/
│   │   ├── dashboard/
│   │   ├── rooms/
│   │   ├── tenants/
│   │   ├── payments/
│   │   │   └── invoice.blade.php # Template invoice PDF
│   │   ├── expenses/
│   │   ├── reminders/
│   │   ├── reports/
│   │   └── activity-logs/
│   └── public/
│       ├── index.blade.php       # Landing page publik
│       └── room-detail.blade.php
└── routes/
    ├── web.php
    └── console.php               # Scheduler
```

---

## ⏰ Scheduler (Cron Job)

Tambahkan cron berikut di server (cPanel / Linux):

```bash
* * * * * cd /path/to/kost-manajemen && php artisan schedule:run >> /dev/null 2>&1
```

Jadwal yang terdaftar di `routes/console.php`:

| Command | Fungsi | Jadwal |
|---------|--------|--------|
| `reminders:notify` | Log penghuni yang perlu diingatkan | Setiap hari 08.00 WIB |
| `rooms:sync-status` | Sinkronisasi status semua kamar | Setiap hari 00.00 WIB |

Test manual:
```bash
php artisan reminders:notify
php artisan rooms:sync-status
```

---

## 📦 Library yang Digunakan

| Library | Fungsi |
|---------|--------|
| `laravel/breeze` | Authentication (Login, Logout, Session) |
| `barryvdh/laravel-dompdf` | Generate invoice & laporan PDF |
| `maatwebsite/excel` | Export laporan CSV/Excel |

**Frontend (via CDN):**
- [Tailwind CSS](https://tailwindcss.com) — UI styling
- [Chart.js](https://chartjs.org) — Grafik dashboard
- [SweetAlert2](https://sweetalert2.github.io) — Konfirmasi dialog & notifikasi

---

## 🚀 Penggunaan

### Alur Kerja Admin

```
1. Login sebagai Admin/Owner
2. Tambah Kamar → isi data & upload foto
3. Tambah Penghuni → pilih kamar, input data, set durasi sewa
   └── Sistem otomatis: hitung due_date + buat payment pertama + update status kamar
4. Konfirmasi Pembayaran → buka halaman Pembayaran → klik Konfirmasi
   └── Sistem otomatis: hitung denda (jika terlambat) + perpanjang sewa + buat tagihan berikutnya
5. Download Invoice PDF dari halaman detail pembayaran
6. Kirim Reminder WA → buka halaman Reminder → klik tombol per penghuni
7. Lihat Laporan Keuangan → pilih bulan/tahun → export PDF atau CSV
```

### Alur WhatsApp Reminder

```
Halaman Reminder
    ↓
Admin klik "Kirim via WhatsApp"
    ↓
Browser buka tab baru: wa.me/628xxx?text=Halo+[Nama]+...
    ↓
AJAX log ke reminder_logs (status: sent)
    ↓
Badge "Sudah Dikirim Hari Ini" muncul di tombol
```

---

## 🛠️ Server Requirements (Production)

| Komponen | Minimum | Rekomendasi |
|----------|---------|-------------|
| PHP | 8.2 | 8.3 |
| MySQL | 8.0 | 8.0+ |
| Web Server | Apache / Nginx | Nginx |
| RAM | 512 MB | 1 GB+ |
| Storage | 500 MB | 2 GB+ |

**PHP Extensions yang dibutuhkan:**
`BCMath, Ctype, JSON, Mbstring, OpenSSL, PDO, Tokenizer, XML`

---

## 🗺️ Roadmap Pengembangan

- [x] Sistem manajemen kost single-tenant (versi ini)
- [ ] Multi-kost per owner (SaaS multi-tenant)
- [ ] Notifikasi WhatsApp otomatis via API (Fonnte/WaBlas)
- [ ] Portal penghuni (cek tagihan mandiri)
- [ ] Mobile app (React Native / Flutter)
- [ ] Dashboard analytics lanjutan (occupancy rate, revenue forecast)

---

## 📄 Lisensi

Proyek ini dilisensikan di bawah [MIT License](LICENSE).

---

<div align="center">

Dibuat dengan ❤️ menggunakan **Laravel 12**

</div>
