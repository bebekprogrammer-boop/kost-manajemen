@extends('layouts.admin')
@section('title', 'Tambah Kamar')
@section('header', 'Tambah Kamar Baru')

@section('content')
<style>
    :root {
        --g1: #0a2e1a;
        --g2: #0d4a2e;
        --g3: #106b3f;
        --g4: #16a34a;
        --g5: #4ade80;
        --b2: #0c2e68;
        --b3: #1d4ed8;
        --red: #dc2626;
        --card-radius: 20px;
    }

    .form-page { font-family: 'Outfit', 'Plus Jakarta Sans', sans-serif; width: 100%; }

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
        border: 1px solid rgba(22,163,74,0.12);
        max-width: 900px;
        width: 100%;
        overflow: hidden;
    }

    .form-card-header {
        padding: 1.5rem 2rem;
        background: linear-gradient(135deg, #f0fdf4, #eff6ff);
        border-bottom: 1px solid rgba(22,163,74,0.1);
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .form-card-icon {
        width: 40px; height: 40px;
        border-radius: 12px;
        background: linear-gradient(135deg, rgba(22,163,74,0.15), rgba(29,78,216,0.12));
        display: flex; align-items: center; justify-content: center;
        font-size: 1.1rem;
        flex-shrink: 0;
    }

    .form-card-title {
        font-family: 'Instrument Serif', 'DM Serif Display', serif;
        font-size: 1.2rem;
        color: var(--g1);
        letter-spacing: -0.02em;
    }

    .form-card-sub {
        font-size: 0.78rem;
        color: #9aaa9a;
        margin-top: 2px;
    }

    .form-card-body {
        padding: 1.75rem 2rem;
    }

    /* ── Field groups ── */
    .field-group {
        margin-bottom: 1.5rem;
    }

    .field-group-title {
        font-size: 0.72rem;
        font-weight: 700;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        color: #9aaa9a;
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 1px solid rgba(22,163,74,0.08);
    }

    .grid-2 {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
    }

    @media (max-width: 600px) { .grid-2 { grid-template-columns: 1fr; } }

    /* ── Form elements ── */
    .field { display: flex; flex-direction: column; gap: 5px; }

    label.field-label {
        font-size: 0.82rem;
        font-weight: 600;
        color: var(--g1);
    }

    .field-hint {
        font-size: 0.72rem;
        color: #9aaa9a;
        margin-top: 2px;
    }

    input[type="text"],
    input[type="number"],
    select,
    textarea {
        width: 100%;
        padding: 0.65rem 0.9rem;
        border: 1.5px solid rgba(22,163,74,0.2);
        border-radius: 11px;
        font-size: 0.875rem;
        font-family: inherit;
        color: var(--g1);
        background: #fafffe;
        outline: none;
        transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
        -webkit-appearance: none;
    }

    input[type="text"]:focus,
    input[type="number"]:focus,
    select:focus,
    textarea:focus {
        border-color: var(--g4);
        background: white;
        box-shadow: 0 0 0 3px rgba(22,163,74,0.1);
    }

    input[type="text"].is-error,
    input[type="number"].is-error,
    select.is-error {
        border-color: var(--red);
        background: #fff9f9;
    }

    select {
        cursor: pointer;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%237a9a7a' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 0.85rem center;
        padding-right: 2.5rem;
    }

    textarea { resize: vertical; min-height: 90px; line-height: 1.6; }

    .error-msg {
        font-size: 0.75rem;
        color: var(--red);
        font-weight: 500;
        margin-top: 3px;
    }

    /* ── Price input wrapper ── */
    .price-wrap {
        position: relative;
    }

    .price-prefix {
        position: absolute;
        left: 0.9rem;
        top: 50%;
        transform: translateY(-50%);
        font-size: 0.82rem;
        font-weight: 700;
        color: #9aaa9a;
        pointer-events: none;
        user-select: none;
    }

    .price-wrap input { padding-left: 2.6rem; }

    /* Sembunyikan spinner default browser pada input number */
    input[type="number"]::-webkit-inner-spin-button,
    input[type="number"]::-webkit-outer-spin-button { -webkit-appearance: none; margin: 0; }
    input[type="number"] { -moz-appearance: textfield; appearance: textfield; }

    /* ── Facilities checkboxes ── */
    .fac-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 0.6rem;
    }

    @media (max-width: 600px) { .fac-grid { grid-template-columns: repeat(2, 1fr); } }

    .fac-checkbox {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 0.6rem 0.85rem;
        border-radius: 10px;
        border: 1.5px solid rgba(22,163,74,0.15);
        background: #fafffe;
        cursor: pointer;
        transition: all 0.18s ease;
        user-select: none;
    }

    .fac-checkbox:hover {
        border-color: rgba(22,163,74,0.4);
        background: #f0fdf4;
    }

    .fac-checkbox input[type="checkbox"] {
        width: 15px; height: 15px;
        border-radius: 5px;
        border: 1.5px solid rgba(22,163,74,0.4);
        background: white;
        accent-color: var(--g4);
        cursor: pointer;
        flex-shrink: 0;
        /* override global input styles */
        padding: 0;
        box-shadow: none;
    }

    .fac-checkbox input[type="checkbox"]:focus {
        box-shadow: 0 0 0 2px rgba(22,163,74,0.2);
    }

    .fac-checkbox:has(input:checked) {
        border-color: var(--g4);
        background: #f0fdf4;
    }

    .fac-label {
        font-size: 0.82rem;
        font-weight: 500;
        color: var(--g1);
    }

    /* ── Photo upload ── */
    .photo-upload {
        border: 2px dashed rgba(22,163,74,0.25);
        border-radius: 14px;
        padding: 1.5rem;
        text-align: center;
        background: #fafffe;
        cursor: pointer;
        transition: all 0.2s ease;
        position: relative;
    }

    .photo-upload:hover {
        border-color: var(--g4);
        background: #f0fdf4;
    }

    .photo-upload input[type="file"] {
        position: absolute;
        inset: 0;
        opacity: 0;
        cursor: pointer;
        width: 100%; height: 100%;
        padding: 0;
        border: none;
        background: transparent;
        box-shadow: none;
    }

    .photo-upload input[type="file"]:focus {
        box-shadow: none;
    }

    .upload-icon { font-size: 1.75rem; margin-bottom: 0.4rem; }

    .upload-text {
        font-size: 0.875rem;
        font-weight: 600;
        color: var(--g2);
    }

    .upload-sub {
        font-size: 0.75rem;
        color: #9aaa9a;
        margin-top: 3px;
    }

    .upload-badge {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        margin-top: 8px;
        padding: 0.25rem 0.65rem;
        background: rgba(22,163,74,0.1);
        border-radius: 99px;
        font-size: 0.7rem;
        font-weight: 700;
        color: var(--g3);
        letter-spacing: 0.04em;
    }

    /* Preview thumbnails */
    #photo-preview {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        margin-top: 0.75rem;
    }

    .preview-thumb {
        width: 68px; height: 68px;
        border-radius: 10px;
        object-fit: cover;
        border: 2px solid rgba(22,163,74,0.2);
    }

    /* ── Divider ── */
    .form-divider {
        height: 1px;
        background: linear-gradient(90deg, rgba(22,163,74,0.12), transparent);
        margin: 1.5rem 0;
    }

    /* ── Footer actions ── */
    .form-footer {
        padding: 1.25rem 2rem;
        background: linear-gradient(135deg, #f8fff8, #f5f8ff);
        border-top: 1px solid rgba(22,163,74,0.08);
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .footer-hint {
        font-size: 0.78rem;
        color: #9aaa9a;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .footer-actions { display: flex; gap: 0.625rem; }

    .btn-cancel {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 0.65rem 1.25rem;
        border-radius: 11px;
        border: 1.5px solid rgba(22,163,74,0.2);
        background: white;
        color: var(--g1);
        font-size: 0.875rem;
        font-weight: 600;
        font-family: inherit;
        text-decoration: none;
        cursor: pointer;
        transition: all 0.18s ease;
    }

    .btn-cancel:hover {
        background: var(--g1);
        color: white;
        border-color: var(--g1);
    }

    .btn-save {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 0.65rem 1.6rem;
        border-radius: 11px;
        border: none;
        background: linear-gradient(135deg, var(--g4), var(--b3));
        color: white;
        font-size: 0.875rem;
        font-weight: 700;
        font-family: inherit;
        cursor: pointer;
        box-shadow: 0 4px 14px rgba(22,163,74,0.35);
        transition: all 0.22s ease;
    }

    .btn-save:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 22px rgba(22,163,74,0.42);
    }

    .btn-save:active { transform: translateY(0); }

    /* Entry animation */
    .form-card {
        opacity: 0;
        transform: translateY(14px);
        animation: cardIn 0.45s ease 0.05s forwards;
    }

    @keyframes cardIn {
        to { opacity: 1; transform: translateY(0); }
    }
</style>

<div class="form-page">

    <div class="section-label">Tambah Kamar Baru</div>

    <div class="form-card">

        {{-- Header --}}
        <div class="form-card-header">
            <div class="form-card-icon">🏠</div>
            <div>
                <div class="form-card-title">Data Kamar</div>
                <div class="form-card-sub">Isi informasi kamar dengan lengkap</div>
            </div>
        </div>

        <form action="{{ route('admin.rooms.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-card-body">

                {{-- Basic info --}}
                <div class="field-group">
                    <div class="field-group-title">Informasi Dasar</div>
                    <div class="grid-2">
                        <div class="field">
                            <label class="field-label" for="room_number">No. Kamar</label>
                            <input
                                type="text"
                                id="room_number"
                                name="room_number"
                                value="{{ old('room_number') }}"
                                placeholder="Contoh: A-101"
                                required
                                class="{{ $errors->has('room_number') ? 'is-error' : '' }}"
                            >
                            @error('room_number')
                                <span class="error-msg">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="field">
                            <label class="field-label" for="type">Tipe Kamar</label>
                            <select id="type" name="type" required>
                                <option value="regular" {{ old('type') == 'regular' ? 'selected' : '' }}>Reguler</option>
                                <option value="vip"     {{ old('type') == 'vip'     ? 'selected' : '' }}>VIP</option>
                                <option value="vvip"    {{ old('type') == 'vvip'    ? 'selected' : '' }}>VVIP</option>
                            </select>
                        </div>

                        <div class="field">
                            <label class="field-label" for="price">Harga Sewa</label>
                            <div class="price-wrap">
                                <span class="price-prefix">Rp</span>
                                <input
                                    type="number"
                                    id="price"
                                    name="price"
                                    value="{{ old('price') }}"
                                    placeholder="600000"
                                    required
                                    min="0"
                                    step="1"
                                >
                            </div>
                            <span class="field-hint">Per bulan</span>
                        </div>

                        <div class="field">
                            <label class="field-label" for="floor">Lantai</label>
                            <input
                                type="number"
                                id="floor"
                                name="floor"
                                value="{{ old('floor', 1) }}"
                                required
                                min="1"
                                max="20"
                            >
                        </div>
                    </div>
                </div>

                <div class="form-divider"></div>

                {{-- Facilities --}}
                <div class="field-group">
                    <div class="field-group-title">Fasilitas Kamar</div>
                    <div class="fac-grid">
                        @foreach(['AC', 'Kamar Mandi Dalam', 'WiFi', 'TV', 'Lemari', 'Kasur Springbed', 'Meja Belajar', 'Kulkas', 'Water Heater'] as $fac)
                        <label class="fac-checkbox">
                            <input
                                type="checkbox"
                                name="facilities[]"
                                value="{{ $fac }}"
                                {{ in_array($fac, old('facilities', [])) ? 'checked' : '' }}
                            >
                            <span class="fac-label">{{ $fac }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>

                <div class="form-divider"></div>

                {{-- Description --}}
                <div class="field-group" style="margin-bottom:0;">
                    <div class="field-group-title">Detail Tambahan</div>
                    <div class="field" style="margin-bottom:1rem;">
                        <label class="field-label" for="description">Deskripsi Kamar</label>
                        <textarea
                            id="description"
                            name="description"
                            placeholder="Ceritakan keunggulan atau detail kamar ini..."
                        >{{ old('description') }}</textarea>
                    </div>

                    {{-- Photo upload --}}
                    <div class="field">
                        <label class="field-label">Foto Kamar</label>
                        <div class="photo-upload" id="dropZone">
                            <input
                                type="file"
                                name="photos[]"
                                multiple
                                accept="image/*"
                                id="photoInput"
                                onchange="previewPhotos(this)"
                            >
                            <div class="upload-icon">📷</div>
                            <div class="upload-text">Klik atau seret foto ke sini</div>
                            <div class="upload-sub">PNG, JPG, WEBP — Maks. 2MB per foto</div>
                            <div class="upload-badge">
                                <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                                Bisa pilih lebih dari 1 foto
                            </div>
                        </div>
                        <div id="photo-preview"></div>
                        @error('photos.*')
                            <span class="error-msg">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

            </div>{{-- /form-card-body --}}

            {{-- Footer --}}
            <div class="form-footer">
                <div class="footer-hint">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    Semua kolom bertanda wajib diisi
                </div>
                <div class="footer-actions">
                    <a href="{{ route('admin.rooms.index') }}" class="btn-cancel">
                        Batal
                    </a>
                    <button type="submit" class="btn-save">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                        Simpan Kamar
                    </button>
                </div>
            </div>

        </form>
    </div>{{-- /form-card --}}
</div>

<script>
    function previewPhotos(input) {
        const preview = document.getElementById('photo-preview');
        preview.innerHTML = '';

        if (!input.files.length) return;

        Array.from(input.files).forEach(file => {
            if (!file.type.startsWith('image/')) return;
            const reader = new FileReader();
            reader.onload = e => {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.className = 'preview-thumb';
                img.title = file.name;
                preview.appendChild(img);
            };
            reader.readAsDataURL(file);
        });

        // Update upload zone text
        const count = input.files.length;
        const zone = document.getElementById('dropZone');
        zone.querySelector('.upload-text').textContent =
            count + ' foto dipilih';
    }
</script>

@endsection
