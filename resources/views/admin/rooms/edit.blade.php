@extends('layouts.admin')
@section('title', 'Edit Kamar')
@section('header', 'Edit Data Kamar')

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
        --amber: #d97706;
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
        opacity: 0;
        transform: translateY(14px);
        animation: cardIn 0.45s ease 0.05s forwards;
    }

    @keyframes cardIn {
        to { opacity: 1; transform: translateY(0); }
    }

    .form-card-header {
        padding: 1.5rem 2rem;
        background: linear-gradient(135deg, #f0fdf4, #eff6ff);
        border-bottom: 1px solid rgba(22,163,74,0.1);
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .form-card-header-left { display: flex; align-items: center; gap: 12px; }

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

    .form-card-sub { font-size: 0.78rem; color: #9aaa9a; margin-top: 2px; }

    /* Edit mode badge */
    .edit-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 0.3rem 0.85rem;
        border-radius: 99px;
        background: rgba(217,119,6,0.1);
        border: 1px solid rgba(217,119,6,0.2);
        font-size: 0.72rem;
        font-weight: 700;
        color: var(--amber);
        letter-spacing: 0.04em;
        text-transform: uppercase;
    }

    .edit-dot {
        width: 6px; height: 6px;
        border-radius: 50%;
        background: var(--amber);
    }

    .form-card-body { padding: 1.75rem 2rem; }

    /* ── Field groups ── */
    .field-group { margin-bottom: 1.5rem; }

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

    .field { display: flex; flex-direction: column; gap: 5px; }

    label.field-label {
        font-size: 0.82rem;
        font-weight: 600;
        color: var(--g1);
    }

    .field-hint { font-size: 0.72rem; color: #9aaa9a; margin-top: 2px; }

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

    select {
        cursor: pointer;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%237a9a7a' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 0.85rem center;
        padding-right: 2.5rem;
    }

    textarea { resize: vertical; min-height: 90px; line-height: 1.6; }

    .error-msg { font-size: 0.75rem; color: var(--red); font-weight: 500; margin-top: 3px; }

    /* Price prefix */
    .price-wrap { position: relative; }
    .price-prefix {
        position: absolute;
        left: 0.9rem; top: 50%;
        transform: translateY(-50%);
        font-size: 0.82rem;
        font-weight: 700;
        color: #9aaa9a;
        pointer-events: none;
    }
    .price-wrap input { padding-left: 2.6rem; }

    /* ── Facilities ── */
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

    .fac-checkbox:hover { border-color: rgba(22,163,74,0.4); background: #f0fdf4; }

    .fac-checkbox input[type="checkbox"] {
        width: 15px; height: 15px;
        border-radius: 5px;
        border: 1.5px solid rgba(22,163,74,0.4);
        background: white;
        accent-color: var(--g4);
        cursor: pointer;
        flex-shrink: 0;
        padding: 0;
        box-shadow: none;
    }

    .fac-checkbox input[type="checkbox"]:focus { box-shadow: 0 0 0 2px rgba(22,163,74,0.2); }
    .fac-checkbox:has(input:checked) { border-color: var(--g4); background: #f0fdf4; }
    .fac-label { font-size: 0.82rem; font-weight: 500; color: var(--g1); }

    /* ── Photo upload zone ── */
    .photo-upload {
        border: 2px dashed rgba(22,163,74,0.25);
        border-radius: 14px;
        padding: 1.25rem;
        text-align: center;
        background: #fafffe;
        cursor: pointer;
        transition: all 0.2s ease;
        position: relative;
    }

    .photo-upload:hover { border-color: var(--g4); background: #f0fdf4; }

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

    .photo-upload input[type="file"]:focus { box-shadow: none; }

    .upload-icon { font-size: 1.5rem; margin-bottom: 0.3rem; }
    .upload-text { font-size: 0.875rem; font-weight: 600; color: var(--g2); }
    .upload-sub  { font-size: 0.75rem; color: #9aaa9a; margin-top: 3px; }

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

    /* ── Existing photos grid ── */
    .existing-photos-label {
        font-size: 0.72rem;
        font-weight: 700;
        letter-spacing: 0.07em;
        text-transform: uppercase;
        color: #9aaa9a;
        margin-bottom: 0.75rem;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .existing-photos-label::before {
        content: '';
        display: block;
        width: 12px; height: 2px;
        background: rgba(22,163,74,0.3);
        border-radius: 2px;
    }

    .existing-photos-grid {
        display: flex;
        flex-wrap: wrap;
        gap: 0.625rem;
        margin-bottom: 1rem;
    }

    .photo-item {
        position: relative;
        width: 80px; height: 80px;
        border-radius: 12px;
        overflow: hidden;
        border: 2px solid rgba(22,163,74,0.15);
        transition: border-color 0.2s;
        flex-shrink: 0;
    }

    .photo-item:hover { border-color: rgba(220,38,38,0.4); }

    .photo-item img {
        width: 100%; height: 100%;
        object-fit: cover;
        display: block;
    }

    /* Delete overlay */
    .photo-delete-overlay {
        position: absolute;
        inset: 0;
        background: rgba(220,38,38,0);
        display: flex;
        align-items: center;
        justify-content: center;
        transition: background 0.2s;
        cursor: pointer;
    }

    .photo-item:hover .photo-delete-overlay {
        background: rgba(220,38,38,0.65);
    }

    .photo-delete-btn {
        opacity: 0;
        background: none;
        border: none;
        color: white;
        font-size: 1.2rem;
        cursor: pointer;
        transition: opacity 0.2s;
        padding: 0;
        line-height: 1;
    }

    .photo-item:hover .photo-delete-btn { opacity: 1; }

    /* Marked for deletion */
    .photo-item.marked {
        border-color: var(--red);
        opacity: 0.45;
    }

    .photo-item.marked .photo-delete-overlay {
        background: rgba(220,38,38,0.3);
    }

    .photo-item.marked .photo-delete-btn {
        opacity: 1;
        font-size: 0.8rem;
    }

    /* New photo preview */
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

    /* ── Footer ── */
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

    .btn-cancel:hover { background: var(--g1); color: white; border-color: var(--g1); }

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

    .btn-save:hover { transform: translateY(-2px); box-shadow: 0 8px 22px rgba(22,163,74,0.42); }
    .btn-save:active { transform: translateY(0); }
</style>

<div class="form-page">

    <div class="section-label">Edit Data Kamar</div>

    <div class="form-card">

        {{-- Header --}}
        <div class="form-card-header">
            <div class="form-card-header-left">
                <div class="form-card-icon">✏️</div>
                <div>
                    <div class="form-card-title">Kamar {{ $room->room_number }}</div>
                    <div class="form-card-sub">Perbarui informasi kamar di bawah</div>
                </div>
            </div>
            <div class="edit-badge">
                <div class="edit-dot"></div>
                Mode Edit
            </div>
        </div>

        <form action="{{ route('admin.rooms.update', $room) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')

            {{-- Hidden inputs untuk foto yang dihapus --}}
            <div id="deleted-photos-inputs"></div>

            <div class="form-card-body">

                {{-- Informasi Dasar --}}
                <div class="field-group">
                    <div class="field-group-title">Informasi Dasar</div>
                    <div class="grid-2">
                        <div class="field">
                            <label class="field-label" for="room_number">No. Kamar</label>
                            <input
                                type="text"
                                id="room_number"
                                name="room_number"
                                value="{{ old('room_number', $room->room_number) }}"
                                required
                            >
                            @error('room_number')
                                <span class="error-msg">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="field">
                            <label class="field-label" for="type">Tipe Kamar</label>
                            <select id="type" name="type" required>
                                <option value="regular" {{ old('type', $room->type) == 'regular' ? 'selected' : '' }}>Reguler</option>
                                <option value="vip"     {{ old('type', $room->type) == 'vip'     ? 'selected' : '' }}>VIP</option>
                                <option value="vvip"    {{ old('type', $room->type) == 'vvip'    ? 'selected' : '' }}>VVIP</option>
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
                                    value="{{ old('price', round($room->price)) }}"
                                    required
                                    min="0"
                                    step="1000"
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
                                value="{{ old('floor', $room->floor) }}"
                                required
                                min="1"
                                max="20"
                            >
                        </div>
                    </div>
                </div>

                <div class="form-divider"></div>

                {{-- Fasilitas --}}
                <div class="field-group">
                    <div class="field-group-title">Fasilitas Kamar</div>
                    @php $currentFacilities = old('facilities', $room->facilities ?? []); @endphp
                    <div class="fac-grid">
                        @foreach(['AC', 'Kamar Mandi Dalam', 'WiFi', 'TV', 'Lemari', 'Kasur Springbed', 'Meja Belajar', 'Kulkas', 'Water Heater'] as $fac)
                        <label class="fac-checkbox">
                            <input
                                type="checkbox"
                                name="facilities[]"
                                value="{{ $fac }}"
                                {{ in_array($fac, $currentFacilities) ? 'checked' : '' }}
                            >
                            <span class="fac-label">{{ $fac }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>

                <div class="form-divider"></div>

                {{-- Deskripsi + Foto --}}
                <div class="field-group" style="margin-bottom:0;">
                    <div class="field-group-title">Detail Tambahan</div>

                    <div class="field" style="margin-bottom:1rem;">
                        <label class="field-label" for="description">Deskripsi Kamar</label>
                        <textarea
                            id="description"
                            name="description"
                            placeholder="Ceritakan keunggulan atau detail kamar ini..."
                        >{{ old('description', $room->description) }}</textarea>
                    </div>

                    {{-- Existing photos --}}
                    @if($room->photos && count($room->photos) > 0)
                    <div style="margin-bottom:1rem;">
                        <div class="existing-photos-label">Foto Saat Ini — klik foto untuk tandai hapus</div>
                        <div class="existing-photos-grid" id="existingPhotos">
                            @foreach($room->photos as $index => $photo)
                            <div class="photo-item" data-photo="{{ $photo }}" data-index="{{ $index }}">
                                <img src="{{ asset('storage/' . $photo) }}" alt="Foto {{ $index + 1 }}">
                                <div class="photo-delete-overlay" onclick="togglePhotoDelete(this.parentElement)">
                                    <button type="button" class="photo-delete-btn">✕</button>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <div style="font-size:0.72rem; color:#9aaa9a; margin-top:-0.25rem;">
                            Foto yang ditandai merah akan dihapus saat disimpan
                        </div>
                    </div>
                    @endif

                    {{-- New photo upload --}}
                    <div class="field">
                        <label class="field-label">Tambah Foto Baru</label>
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
                    Perubahan akan langsung tersimpan
                </div>
                <div class="footer-actions">
                    <a href="{{ route('admin.rooms.index') }}" class="btn-cancel">Batal</a>
                    <button type="submit" class="btn-save">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                        Perbarui Kamar
                    </button>
                </div>
            </div>

        </form>
    </div>

</div>

<script>
    // Toggle photo marked for deletion
    function togglePhotoDelete(item) {
        const isMarked = item.classList.contains('marked');
        const photoPath = item.dataset.photo;
        const container = document.getElementById('deleted-photos-inputs');

        if (isMarked) {
            // Unmark — remove hidden input
            item.classList.remove('marked');
            item.querySelector('.photo-delete-btn').textContent = '✕';
            const existing = container.querySelector(`input[value="${CSS.escape(photoPath)}"]`);
            if (existing) existing.remove();
        } else {
            // Mark for deletion — add hidden input
            item.classList.add('marked');
            item.querySelector('.photo-delete-btn').textContent = '↩';
            const input = document.createElement('input');
            input.type  = 'hidden';
            input.name  = 'delete_photos[]';
            input.value = photoPath;
            container.appendChild(input);
        }
    }

    // Preview newly selected photos
    function previewPhotos(input) {
        const preview = document.getElementById('photo-preview');
        preview.innerHTML = '';

        if (!input.files.length) return;

        Array.from(input.files).forEach(file => {
            if (!file.type.startsWith('image/')) return;
            const reader = new FileReader();
            reader.onload = e => {
                const img = document.createElement('img');
                img.src       = e.target.result;
                img.className = 'preview-thumb';
                img.title     = file.name;
                preview.appendChild(img);
            };
            reader.readAsDataURL(file);
        });

        const count = input.files.length;
        document.querySelector('#dropZone .upload-text').textContent =
            count + ' foto baru dipilih';
    }
</script>

@endsection
