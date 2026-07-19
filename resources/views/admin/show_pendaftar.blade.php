<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet"
href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>
<body class="bg-light">@section('content')
    <style>
        .form-box {
            border-radius: 16px;
            background: #ffffff;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            border: none;
        }

        .form-section-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: #2c3e50;
            border-left: 4px solid #0d6efd;
            padding-left: 10px;
            margin-bottom: 20px;
        }

        .form-label-custom {
            font-size: 0.85rem;
            font-weight: 600;
            color: #5c6b73;
            margin-bottom: 6px;
        }

        .form-control-custom {
            border-radius: 10px;
            border: 1px solid #ced4da;
            padding: 10px 15px;
            font-size: 0.95rem;
            transition: all 0.2s ease;
        }

        .form-control-custom:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 4px rgba(13, 110, 253, 0.15);
        }

        .card-berkas {
            border-radius: 12px;
            background: #f8f9fa;
            border: 1px solid #e9ecef;
        }

        .form-card {
            border-radius: 18px;
            border: none;
            box-shadow: 0 .35rem 1rem rgba(0, 0, 0, .08);
        }

        .input-group-text {
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            min-width: 50px;
            justify-content: center;
        }

        .form-control,
        .form-select {

            border-radius: 0 10px 10px 0;

            min-height: 48px;

            font-weight: 500;

        }

        .form-control:focus,
        .form-select:focus {

            border-color: #0d6efd;

            box-shadow: 0 0 0 .15rem rgba(13, 110, 253, .15);

        }

        .form-label {

            font-size: .82rem;

            letter-spacing: .4px;

        }
    </style>

    @php
        $jumlahBerkas = collect([
            $pendaftar->file_ktp,
            $pendaftar->file_kk,
            $pendaftar->file_ijazah,
            $pendaftar->file_akta,
        ])
            ->filter()
            ->count();
    @endphp

    <!-- HEADER -->
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <div>
                    <a href="{{ url('/elearning') }}" class="btn btn-outline-secondary rounded-pill mb-3">
                        <i class="bi bi-arrow-left"></i>
                        Kembali
                    </a>
                    <h2 class="fw-bold mb-1">
                        {{ $pendaftar->nama }}
                    </h2>

                    <div class="text-muted mb-2">
                        <i class="bi bi-mortarboard-fill text-primary"></i>
                        {{ $pendaftar->paket }}
                    </div>
                    <small class="text-secondary">
                        <i class="bi bi-calendar-event"></i>
                        Terdaftar :
                        {{ $pendaftar->created_at->format('d F Y') }}
                    </small>
                </div>
                <div class="text-end">
                    <div class="mb-2">
                        <small class="text-muted d-block">
                            Nomor Pendaftaran :
                        </small>

                        <h5 class="fw-bold text-primary mb-2">
                            #{{ str_pad($pendaftar->id, 5, '0', STR_PAD_LEFT) }}
                        </h5>
                    </div>

                    <a href="{{ route('admin.pendaftaran.cetak', $pendaftar->id) }}" target="_blank"
                        class="btn btn-danger rounded-pill px-4">
                        <i class="bi bi-printer-fill"></i>
                        Cetak Formulir
                    </a>
                </div>
            </div>
        </div>
    </div>



                <!-- Layout Grid Utama -->
                <div class="row g-4">
                    <!-- BAGIAN KIRI: Form Hasil Biodata Pendaftar -->
                    <div class="col-lg-8">
                        <div class="card form-box p-4 p-md-5">

                            <!-- JALUR FORM UTAMA (TIDAK BERUBAH) -->
                            <form action="{{ route('admin.pendaftaran.update', $pendaftar->id) }}" method="POST">
                                <div class="alert alert-light border rounded-4 mb-4">
                                    <h5 class="fw-bold mb-2">
                                        <i class="bi bi-person-vcard-fill text-primary me-2"></i>
                                        Biodata Pendaftar
                                    </h5>
                                    <small class="text-muted">
                                        Admin dapat memperbarui data apabila ditemukan kesalahan sebelum proses verifikasi
                                        selesai.
                                    </small>
                                </div>
                                @csrf
                                @method('PUT')

                                <!-- SEKSI 1: DATA PROFIL UTAMA -->
                                <h5 class="fw-bold mb-3 text-primary border-bottom pb-2">
                                    <i class="bi bi-person-vcard me-2"></i>Informasi Profil & Pilihan Program
                                </h5>

                                <div class="row g-3 mb-4">
                                    <!-- 1. Nama Lengkap (Sekarang pakai Input Group + Ikon) -->
                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold text-secondary">Nama Lengkap</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light text-muted"
                                                style="border-radius: 8px 0 0 8px;"><i class="bi bi-person-fill"></i></span>
                                            <input type="text" name="nama" class="form-control fw-bold text-dark"
                                                value="{{ $pendaftar->nama }}" required
                                                style="border-radius: 0 8px 8px 0; padding: 10px;">
                                        </div>
                                    </div>

                                    <!-- 2. Pilihan Program Paket (Sekarang pakai Input Group + Ikon) -->
                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold text-secondary">Pilihan Program Paket</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light text-muted"
                                                style="border-radius: 8px 0 0 8px;"><i
                                                    class="bi bi-journal-bookmark-fill"></i></span>
                                            <select name="paket" class="form-select fw-bold" required
                                                style="border-radius: 0 8px 8px 0; padding: 10px;">
                                                <option value="Paket A"
                                                    {{ $pendaftar->paket == 'Paket A' ? 'selected' : '' }}>Paket A
                                                    (Setara SD)</option>
                                                <option value="Paket B"
                                                    {{ $pendaftar->paket == 'Paket B' ? 'selected' : '' }}>Paket B
                                                    (Setara SMP)</option>
                                                <option value="Paket C"
                                                    {{ $pendaftar->paket == 'Paket C' ? 'selected' : '' }}>Paket C
                                                    (Setara SMA)</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- 3. No. WhatsApp / HP (Sudah konsisten pakai Input Group) -->
                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold text-secondary">No. WhatsApp / HP</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light text-muted"
                                                style="border-radius: 8px 0 0 8px;"><i class="bi bi-whatsapp"></i></span>
                                            <input type="text" name="nohp" class="form-control fw-bold"
                                                value="{{ $pendaftar->nohp }}" required
                                                style="border-radius: 0 8px 8px 0; padding: 10px;">
                                        </div>
                                    </div>
                                    <div class="row g-3 mb-4">
                                        {{-- 4. Tempat & tgl lahir --}}
                                        <div class="col-md-6">
                                            <label class="form-label small fw-bold text-secondary">
                                                Tempat Lahir
                                            </label>
                                            <div class="input-group">
                                                <span class="input-group-text">
                                                    <i class="bi bi-geo-alt-fill"></i>
                                                </span>
                                                <input type="text" name="tempat_lahir" class="form-control"
                                                    value="{{ old('tempat_lahir', $pendaftar->tempat_lahir) }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label small fw-bold text-secondary">
                                                Tanggal Lahir
                                            </label>
                                            <div class="input-group">
                                                <span class="input-group-text">
                                                    <i class="bi bi-calendar-event-fill"></i>
                                                </span>
                                                <input type="date" name="tanggal_lahir" class="form-control"
                                                    value="{{ old('tanggal_lahir', $pendaftar->tanggal_lahir) }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row g-3 mb-4">
                                        {{-- 5. Jenis kelamin & Alamat --}}
                                        <div class="col-md-6">
                                            <label class="form-label small fw-bold text-secondary">
                                                Jenis Kelamin
                                            </label>
                                            <div class="input-group">
                                                <span class="input-group-text">
                                                    <i class="bi bi-gender-ambiguous"></i>
                                                </span>
                                                <select name="jenis_kelamin" class="form-select">
                                                    <option value="">Pilih Jenis Kelamin</option>
                                                    <option value="Laki-laki"
                                                        {{ $pendaftar->jenis_kelamin == 'Laki-laki' ? 'selected' : '' }}>
                                                        Laki-laki
                                                    </option>
                                                    <option value="Perempuan"
                                                        {{ $pendaftar->jenis_kelamin == 'Perempuan' ? 'selected' : '' }}>
                                                        Perempuan
                                                    </option>
                                                </select>
                                            </div>

                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label small fw-bold text-secondary">
                                                Alamat
                                            </label>
                                            <textarea name="alamat" rows="2" class="form-control">{{ old('alamat', $pendaftar->alamat) }}</textarea>
                                        </div>
                                    </div>
                                    <!-- 6. Status Berkas (Menggantikan Status Akun, pakai Input Group + Ikon) -->
                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold text-secondary">Status Berkas</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light text-muted"
                                                style="border-radius: 8px 0 0 8px;"><i
                                                    class="bi bi-info-circle-fill"></i></span>
                                            <input type="text"
                                                class="form-control bg-light fw-bold text-uppercase @if ($pendaftar->status == 'Diterima') text-success @elseif($pendaftar->status == 'Ditolak') text-danger @else text-warning @endif"
                                                value="{{ $pendaftar->status }}" readonly
                                                style="border-radius: 0 8px 8px 0; padding: 10px;">
                                        </div>
                                    </div>
                                </div>

                                {{-- <hr class="text-muted opacity-25 my-4"> --}}
                                <div class="card-body">
                                    <div class="d-flex gap-2">
                                        <button type="reset" class="btn btn-outline-secondary rounded-pill">
                                            Reset
                                        </button>
                                        <button type="submit" class="btn btn-primary rounded-pill">
                                            Simpan Perubahan
                                        </button>
                                    </div>
                                    </div>
                            </form>
                            @if ($pendaftar->status == 'Pending')
                                <hr>
                                <div class="card border-0 bg-light rounded-4 mt-3">
                                    <div class="card-body">
                                        <h6 class="fw-bold mb-3">
                                            <i class="bi bi-shield-check text-success me-2"></i>
                                            Verifikasi Berkas
                                        </h6>
                                        <p class="text-muted small mb-3">
                                            Setelah seluruh data dan dokumen diperiksa, silakan pilih keputusan berikut.
                                        </p>
                                        <div class="d-flex gap-2">
                                            <form
                                                action="{{ route('admin.pendaftaran.status', ['id' => $pendaftar->id, 'status' => 'Ditolak']) }}"
                                                method="POST">
                                                @csrf
                                                <button class="btn btn-danger rounded-pill">
                                                    <i class="bi bi-x-circle-fill me-1"></i>
                                                    Tolak Berkas
                                                </button>
                                            </form>

                                            <form
                                                action="{{ route('admin.pendaftaran.status', ['id' => $pendaftar->id, 'status' => 'Diterima']) }}"
                                                method="POST">
                                                @csrf
                                                <button class="btn btn-success rounded-pill">
                                                    <i class="bi bi-check-circle-fill me-1"></i>
                                                    Terima Berkas
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endif

                        </div>

                    </div>
                </div>


                <!-- BAGIAN KANAN: Berkas Lampiran Dokumen -->
                <div class="col-lg-4">
                    <div class="card form-card p-4">
                        <div class="row text-center mb-4">
                            <div class="col-6">
                                <div class="border rounded-4 p-3 bg-light">
                                    <h3 class="fw-bold text-success mb-0">
                                        {{ $jumlahBerkas }}/4
                                    </h3>
                                    <small class="text-muted">
                                        Berkas Lengkap
                                    </small>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="border rounded-4 p-3 bg-light">
                                    @if ($jumlahBerkas == 4)
                                        <h5 class="text-success fw-bold">
                                            Lengkap
                                        </h5>
                                    @else
                                        <h5 class="text-warning fw-bold">
                                            Belum Lengkap
                                        </h5>
                                    @endif
                                    <small class="text-muted">
                                        Status Dokumen
                                    </small>
                                </div>
                            </div>
                        </div>
                        <div class="form-section-title mb-3"><i class="bi bi-folder2-open text-warning me-2"></i>Berkas
                            Persyaratan
                            Pendaftaran</div>
                        <p class="text-muted small mb-4">Seluruh dokumen berikut diunggah oleh calon siswa saat melakukan
                            pendaftaran
                            online dan dapat diperiksa oleh Admin sebelum proses verifikasi.</p>

                        <div class="d-flex flex-column gap-3">

                            @php
                                $berkas = [
                                    'file_ktp' => [
                                        'label' => 'KTP Pendaftar / Orang Tua',
                                        'icon' => 'bi-card-image',
                                        'color' => 'btn-primary',
                                    ],
                                    'file_kk' => [
                                        'label' => 'Kartu Keluarga (KK)',
                                        'icon' => 'bi-file-earmark-person',
                                        'color' => 'btn-info text-white',
                                    ],
                                    'file_ijazah' => [
                                        'label' => 'Ijazah Terakhir',
                                        'icon' => 'bi-file-earmark-medical',
                                        'color' => 'btn-success',
                                    ],
                                    'file_akta' => [
                                        'label' => 'Akta Kelahiran',
                                        'icon' => 'bi-file-earmark-text',
                                        'color' => 'btn-secondary',
                                    ],
                                ];
                            @endphp

                            @foreach ($berkas as $field => $info)
                                <div class="card shadow-sm border-0 rounded-4 mb-3">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="rounded-circle bg-light p-3 me-3">
                                                <i class="bi {{ $info['icon'] }} fs-4 text-primary"></i>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="fw-bold mb-1">
                                                    {{ $info['label'] }}
                                                </h6>
                                                @if ($pendaftar->$field)
                                                    <span class="badge bg-success">
                                                        <i class="bi bi-check-circle-fill"></i>
                                                        Berkas tersedia
                                                    </span>
                                                @else
                                                    <span class="badge bg-danger">
                                                        <i class="bi bi-x-circle-fill"></i>
                                                        Belum diunggah
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        @if (!empty($pendaftar->$field))
                                            <div class="bg-light rounded-3 p-2 mb-3">
                                                <small class="text-muted d-block">
                                                    Nama File
                                                </small>
                                                <div class="fw-semibold text-break">
                                                    {{ basename($pendaftar->$field) }}
                                                </div>
                                            </div>
                                            <div class="d-grid">

                                                <a href="{{ config('app.supabase_url') }}/storage/v1/object/public/{{ config('app.supabase_bucket') }}/{{ $pendaftar->$field }}"
                                                    target="_blank" class="btn {{ $info['color'] }} rounded-pill">

                                                    <i class="bi bi-eye-fill"></i>
                                                    Lihat Dokumen
                                                </a>
                                            </div>
                                        @else
                                            <div class="text-center">
                                                <span class="badge bg-secondary">
                                                    Tidak ada file
                                                </span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <p class="text-muted small mt-4">
                            Pastikan seluruh dokumen sesuai dengan identitas calon siswa sebelum proses verifikasi dan
                            pembuatan akun
                            dilakukan.
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
