@extends('layouts.admin')
@section('title', 'Tambah Penghuni')
@section('header', 'Tambah Penghuni Baru')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&family=Roboto+Slab:wght@700&display=swap');

    :root {
        --g1: #0a2e1a;
        --g2: #0d4a2e;
        --g3: #106b3f;
        --g4: #16a34a;
        --g5: #4ade80;
        --b1: #06193a;
        --b2: #0c2e68;
        --b3: #1d4ed8;
        --b4: #3b82f6;
        --b5: #93c5fd;
        --red: #dc2626;
        --card-radius: 20px;
    }

    .form-page { font-family: 'Roboto', sans-serif; }

    /* ── Section label ── */
    .section-label {
        font-size: 0.7rem;
        font-weight: 700;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: var(--g3);
        display: flex;
        align-items: center;
        gap: 6px;
        margin-bottom: 1.25rem;
    }

    .section-label::before {
        content: '';
        display: block;
        width: 20px; height: 2px;
        background: linear-gradient(90deg, var(--g4), var(--b3));
        border-radius: 2px;
    }

    /* ── Card ── */
    .form-card {
        background: white;
        border-radius: var(--card-radius);
        border: 1px solid rgba(22,163,74,0.1);
        overflow: hidden;
        box-shadow: 0 2px 12px rgba(0,0,0,0.04);
        max-width: 860px;
    }

    .card-header {
        padding: 1.1rem 1.5rem 1rem;
        background: linear-gradient(135deg, #f0fdf4, #eff6ff);
        border-bottom: 1px solid rgba(22,163,74,0.08);
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .card-header-icon {
        width: 32px; height: 32px;
        border-radius: 9px;
        background: linear-gradient(135deg, rgba(22,163,74,0.15), rgba(29,78,216,0.12));
        display: flex; align-items: center; justify-content: center;
        font-size: 0.9rem;
        flex-shrink: 0;
    }

    .card-title {
        font-family: 'Roboto Slab', serif;
        font-size: 0.95rem;
        font-weight: 700;
        color: var(--g1);
    }

    .card-body { padding: 1.75rem 1.5rem; }

    /* ── Form grid ── */
    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.25rem 1.5rem;
    }

    @media (max-width: 640px) {
        .form-grid { grid-template-columns: 1fr; }
    }

    .form-group { display: flex; flex-direction: column; gap: 6px; }
    .form-group.full { grid-column: 1 / -1; }

    /* Section divider within form */
    .form-section-title {
        grid-column: 1 / -1;
        font-size: 0.68rem;
        font-weight: 700;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: var(--g3);
        display: flex;
        align-items: center;
        gap: 8px;
        padding-top: 0.5rem;
    }

    .form-section-title::after {
        content: '';
        flex: 1;
        height: 1px;
        background: linear-gradient(90deg, rgba(22,163,74,0.2), transparent);
    }

    /* ── Labels ── */
    label {
        font-size: 0.75rem;
        font-weight: 700;
        color: #5a7a6a;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        font-family: 'Roboto', sans-serif;
    }

    .label-optional {
        font-size: 0.65rem;
        font-weight: 400;
        color: #9aaa9a;
        text-transform: none;
        letter-spacing: 0;
        margin-left: 4px;
    }

    /* ── Inputs ── */
    .form-input,
    .form-select,
    .form-textarea {
        width: 100%;
        padding: 0.65rem 0.9rem;
        font-size: 0.875rem;
        font-family: 'Roboto', sans-serif;
        color: var(--g1);
        background: white;
        border: 1.5px solid rgba(22,163,74,0.2);
        border-radius: 12px;
        outline: none;
        transition: border-color 0.2s, box-shadow 0.2s;
        box-sizing: border-box;
    }

    .form-input:focus,
    .form-select:focus,
    .form-textarea:focus {
        border-color: rgba(22,163,74,0.55);
        box-shadow: 0 0 0 3px rgba(22,163,74,0.1);
    }

    .form-input::placeholder,
    .form-textarea::placeholder { color: #b0c0b0; }

    .form-textarea { resize: vertical; min-height: 90px; }

    /* File input */
    .form-file-wrap {
        position: relative;
    }

    .form-file {
        width: 100%;
        padding: 0.55rem 0.9rem;
        font-size: 0.82rem;
        font-family: 'Roboto', sans-serif;
        color: var(--g1);
        background: white;
        border: 1.5px dashed rgba(22,163,74,0.3);
        border-radius: 12px;
        outline: none;
        cursor: pointer;
        transition: border-color 0.2s, background 0.2s;
        box-sizing: border-box;
    }

    .form-file:hover {
        border-color: rgba(22,163,74,0.55);
        background: #f8fff8;
    }

    /* Error messages */
    .field-error {
        font-size: 0.75rem;
        color: var(--red);
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    /* ── Form actions ── */
    .form-actions {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 0.75rem;
        margin-top: 1.75rem;
        padding-top: 1.5rem;
        border-top: 1px solid rgba(22,163,74,0.08);
    }

    .btn-cancel {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 0.65rem 1.3rem;
        border-radius: 12px;
        border: 1.5px solid rgba(22,163,74,0.2);
        background: white;
        color: var(--g2);
        font-size: 0.875rem;
        font-weight: 700;
        font-family: 'Roboto', sans-serif;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .btn-cancel:hover {
        background: var(--g1);
        color: white;
        border-color: var(--g1);
    }

    .btn-submit {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 0.65rem 1.5rem;
        background: linear-gradient(135deg, var(--g4), var(--b3));
        color: white;
        font-size: 0.875rem;
        font-weight: 700;
        font-family: 'Roboto', sans-serif;
        border: none;
        border-radius: 12px;
        cursor: pointer;
        box-shadow: 0 4px 14px rgba(22,163,74,0.35);
        transition: all 0.25s ease;
        position: relative;
        overflow: hidden;
    }

    .btn-submit::before {
        content: '';
        position: absolute;
        top: 0; left: -100%;
        width: 100%; height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.15), transparent);
        transition: left 0.5s ease;
    }

    .btn-submit:hover::before { left: 100%; }
    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 22px rgba(22,163,74,0.45);
    }

    /* Entry animation */
    .anim-in {
        opacity: 0;
        transform: translateY(12px);
        animation: pageIn 0.5s ease forwards;
    }

    @keyframes pageIn {
        to { opacity: 1; transform: translateY(0); }
    }

    .anim-in:nth-child(1) { animation-delay: 0.05s; }
    .anim-in:nth-child(2) { animation-delay: 0.12s; }
</style>

<div class="form-page">

    <div class="section-label">Tambah Penghuni Baru</div>

    <div class="form-card anim-in">
        <div class="card-header">
            <div class="card-header-icon">➕</div>
            <div class="card-title">Data Penghuni</div>
        </div>

        <div class="card-body">
            <form action="{{ route('admin.tenants.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-grid">

                    {{-- ── Section: Kamar & Sewa ── --}}
                    <div class="form-section-title">Kamar & Sewa</div>

                    <div class="form-group">
                        <label for="room_id">Pilih Kamar <span class="label-optional">(tersedia)</span></label>
                        <select name="room_id" id="room_id" required class="form-select">
                            <option value="">-- Pilih Kamar --</option>
                            @foreach($rooms as $room)
                                <option value="{{ $room->id }}" {{ old('room_id') == $room->id ? 'selected' : '' }}>
                                    {{ $room->room_number }} — {{ strtoupper($room->type) }} (Rp {{ number_format($room->price, 0, ',', '.') }})
                                </option>
                            @endforeach
                        </select>
                        @error('room_id')
                            <span class="field-error">⚠ {{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="rent_duration">Durasi Sewa Awal</label>
                        <select name="rent_duration" id="rent_duration" required class="form-select">
                            <option value="1"   {{ old('rent_duration') == 1   ? 'selected' : '' }}>1 Hari (H-0)</option>
                            <option value="2"   {{ old('rent_duration') == 2   ? 'selected' : '' }}>2 Hari (H-1)</option>
                            <option value="3"   {{ old('rent_duration') == 3   ? 'selected' : '' }}>3 Hari (H-3)</option>
                            <option value="7"   {{ old('rent_duration') == 7   ? 'selected' : '' }}>7 Hari (H-7)</option>
                            <option value="30"  {{ old('rent_duration') == 30  ? 'selected' : '' }}>1 Bulan (30 Hari)</option>
                            <option value="90"  {{ old('rent_duration') == 90  ? 'selected' : '' }}>3 Bulan (90 Hari)</option>
                            <option value="180" {{ old('rent_duration') == 180 ? 'selected' : '' }}>6 Bulan (180 Hari)</option>
                            <option value="365" {{ old('rent_duration') == 365 ? 'selected' : '' }}>1 Tahun (365 Hari)</option>
                        </select>
                    </div>

                    {{-- ── Section: Identitas ── --}}
                    <div class="form-section-title">Identitas Penghuni</div>

                    <div class="form-group">
                        <label for="name">Nama Lengkap</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required placeholder="Masukkan nama lengkap" class="form-input">
                        @error('name')
                            <span class="field-error">⚠ {{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="phone">No. HP / WhatsApp</label>
                        <input type="text" name="phone" id="phone" value="{{ old('phone') }}" required placeholder="Contoh: 628123456789" class="form-input">
                        @error('phone')
                            <span class="field-error">⚠ {{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="check_in_date">Tanggal Masuk (Check In)</label>
                        <input type="date" name="check_in_date" id="check_in_date" value="{{ old('check_in_date', date('Y-m-d')) }}" required class="form-input">
                        @error('check_in_date')
                            <span class="field-error">⚠ {{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email">Email <span class="label-optional">(opsional)</span></label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" placeholder="contoh@email.com" class="form-input">
                    </div>

                    <div class="form-group">
                        <label for="id_card_number">NIK <span class="label-optional">(nomor KTP)</span></label>
                        <input type="text" name="id_card_number" id="id_card_number" value="{{ old('id_card_number') }}" placeholder="16 digit NIK" class="form-input">
                    </div>

                    <div class="form-group">
                        <label for="id_card_photo">Foto KTP <span class="label-optional">(opsional)</span></label>
                        <input type="file" name="id_card_photo" id="id_card_photo" accept="image/*" class="form-file">
                    </div>

                    {{-- ── Section: Catatan ── --}}
                    <div class="form-section-title">Catatan</div>

                    <div class="form-group full">
                        <label for="notes">Catatan Internal <span class="label-optional">(opsional)</span></label>
                        <textarea name="notes" id="notes" class="form-textarea" placeholder="Catatan tambahan tentang penghuni...">{{ old('notes') }}</textarea>
                    </div>

                </div>

                {{-- ── Actions ── --}}
                <div class="form-actions">
                    <a href="{{ route('admin.tenants.index') }}" class="btn-cancel">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
                        Batal
                    </a>
                    <button type="submit" class="btn-submit">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v14a2 2 0 01-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                        Simpan Penghuni
                    </button>
                </div>

            </form>
        </div>
    </div>

</div>
@endsection
