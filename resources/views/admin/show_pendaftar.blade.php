@section('content')
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
</style>

<div class="container-fluid px-4 py-4">
   <!-- HEADER -->
<div class="d-flex justify-content-between align-items-center flex-wrap mb-4">

    <div>
        <a href="{{ url('/elearning') }}"
            class="btn btn-outline-secondary rounded-pill mb-3">
            <i class="bi bi-arrow-left"></i>
            Kembali
        </a>
        <h3 class="fw-bold mb-1">
            Detail Formulir Pendaftaran
        </h3>
        <small class="text-muted">
            Pemeriksaan data calon siswa
        </small>
    </div>
    <div class="text-end">
        @if($pendaftar->status=='Diterima')
            <span class="badge bg-success fs-6 rounded-pill px-3 py-2">
                DITERIMA
            </span>
        @elseif($pendaftar->status=='Ditolak')
            <span class="badge bg-danger fs-6 rounded-pill px-3 py-2">
                DITOLAK
            </span>
        @else
            <span class="badge bg-warning text-dark fs-6 rounded-pill px-3 py-2">
                MENUNGGU
            </span>
        @endif
        <a href="{{ route('admin.pendaftaran.cetak',$pendaftar->id) }}"
            target="_blank"
            class="btn btn-danger rounded-pill">
            <i class="bi bi-printer-fill"></i>
            Cetak Formulir
        </a>
    </div>
</div>

<!-- INFO SINGKAT -->
<div class="row mb-4">

    <div class="col-md-4 mb-3">

        <div class="card shadow-sm border-0 rounded-4 h-100">
            <div class="card-body">

                <small class="text-muted">
                    Nomor Pendaftaran
                </small>

                <h4 class="fw-bold text-primary">
                    #{{ str_pad($pendaftar->id,5,'0',STR_PAD_LEFT) }}
                </h4>

            </div>
        </div>

    </div>

    <div class="col-md-4 mb-3">

        <div class="card shadow-sm border-0 rounded-4 h-100">
            <div class="card-body">

                <small class="text-muted">
                    Tanggal Mendaftar
                </small>

                <h5 class="fw-bold">
                    {{ \Carbon\Carbon::parse($pendaftar->created_at)->translatedFormat('d F Y') }}
                </h5>

            </div>
        </div>

    </div>

    <div class="col-md-4 mb-3">

        <div class="card shadow-sm border-0 rounded-4 h-100">
            <div class="card-body">

                <small class="text-muted">
                    Program Dipilih
                </small>

                <h4 class="fw-bold text-success">
                    {{ $pendaftar->paket }}
                </h4>

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
                        Admin dapat memperbarui data apabila ditemukan kesalahan sebelum proses verifikasi selesai.
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
                        <span class="input-group-text bg-light text-muted" style="border-radius: 8px 0 0 8px;"><i class="bi bi-person-fill"></i></span>
                        <input type="text" name="nama" class="form-control fw-bold text-dark" value="{{ $pendaftar->nama }}" required style="border-radius: 0 8px 8px 0; padding: 10px;">
                    </div>
                </div>

                <!-- 2. Pilihan Program Paket (Sekarang pakai Input Group + Ikon) -->
                <div class="col-md-6">
                    <label class="form-label small fw-bold text-secondary">Pilihan Program Paket</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light text-muted" style="border-radius: 8px 0 0 8px;"><i class="bi bi-journal-bookmark-fill"></i></span>
                        <select name="paket" class="form-select fw-bold" required style="border-radius: 0 8px 8px 0; padding: 10px;">
                            <option value="Paket A" {{ $pendaftar->paket == 'Paket A' ? 'selected' : '' }}>Paket A (Setara SD)</option>
                            <option value="Paket B" {{ $pendaftar->paket == 'Paket B' ? 'selected' : '' }}>Paket B (Setara SMP)</option>
                            <option value="Paket C" {{ $pendaftar->paket == 'Paket C' ? 'selected' : '' }}>Paket C (Setara SMA)</option>
                        </select>
                    </div>
                </div>

                <!-- 3. No. WhatsApp / HP (Sudah konsisten pakai Input Group) -->
                <div class="col-md-6">
                    <label class="form-label small fw-bold text-secondary">No. WhatsApp / HP</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light text-muted" style="border-radius: 8px 0 0 8px;"><i class="bi bi-whatsapp"></i></span>
                        <input type="text" name="nohp" class="form-control fw-bold" value="{{ $pendaftar->nohp }}" required style="border-radius: 0 8px 8px 0; padding: 10px;">
                    </div>
                </div>

                <!-- 4. Status Berkas (Menggantikan Status Akun, pakai Input Group + Ikon) -->
                <div class="col-md-6">
                    <label class="form-label small fw-bold text-secondary">Status Berkas</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light text-muted" style="border-radius: 8px 0 0 8px;"><i class="bi bi-info-circle-fill"></i></span>
                        <input type="text" class="form-control bg-light fw-bold text-uppercase @if($pendaftar->status == 'Diterima') text-success @elseif($pendaftar->status == 'Ditolak') text-danger @else text-warning @endif" value="{{ $pendaftar->status }}" readonly style="border-radius: 0 8px 8px 0; padding: 10px;">
                    </div>
                </div>
            </div>

                    {{-- <hr class="text-muted opacity-25 my-4"> --}}
                    <div class="d-flex flex-wrap justify-content-between align-items-center mt-4">
                        <div class="d-flex gap-2">
                            <button type="reset" class="btn btn-outline-secondary rounded-pill">
                                Reset
                            </button>
                            <button type="submit" class="btn btn-primary rounded-pill">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                    @if($pendaftar->status == 'Pending')
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
                        <form action="{{ route('admin.pendaftaran.status',['id'=>$pendaftar->id,'status'=>'Ditolak']) }}"
                            method="POST">
                            @csrf
                            <button class="btn btn-danger rounded-pill">
                                <i class="bi bi-x-circle-fill me-1"></i>
                                Tolak Berkas
                            </button>
                        </form>

                        <form action="{{ route('admin.pendaftaran.status',['id'=>$pendaftar->id,'status'=>'Diterima']) }}"
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
                    <div class="card form-box p-4">
                        @php
            $jumlahBerkas = collect([
                $pendaftar->file_ktp,
                $pendaftar->file_kk,
                $pendaftar->file_ijazah,
                $pendaftar->file_akta,
            ])->filter()->count();
        @endphp

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
                            @if($jumlahBerkas == 4)

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
                <div class="form-section-title mb-3"><i class="bi bi-folder2-open text-warning me-2"></i>Berkas Persyaratan Pendaftaran</div>
                <p class="text-muted small mb-4">Seluruh dokumen berikut diunggah oleh calon siswa saat melakukan pendaftaran online dan dapat diperiksa oleh Admin sebelum proses verifikasi.</p>

                <div class="d-flex flex-column gap-3">
                    @foreach([
                        'file_ktp' => ['label' => 'KTP Pendaftar / Orang Tua', 'icon' => 'bi-card-image', 'color' => 'btn-primary'],
                        'file_kk' => ['label' => 'Kartu Keluarga (KK)', 'icon' => 'bi-file-earmark-person', 'color' => 'btn-info text-white'],
                        'file_ijazah' => ['label' => 'Ijazah Terakhir', 'icon' => 'bi-file-earmark-medical', 'color' => 'btn-success'],
                        'file_akta' => ['label' => 'Akta Kelahiran', 'icon' => 'bi-file-earmark-text', 'color' => 'btn-violet text-white']
                    ] as $field => $info)
                        <div class="card-berkas p-3 shadow-sm border-start border-5
                    @if($pendaftar->$field)
                    border-success
                    @else
                    border-danger
                    @endif
                    ">
                    <div class="d-flex align-items-center gap-2">
                         <div class="fs-3 text-secondary"><i class="{{ $info['icon'] }}"></i></div>
                    <div>
                     <span class="fw-bold d-block text-dark small" style="line-height: 1.2;">{{ $info['label'] }}</span>
                    @if($pendaftar->$field)
                        <a href="{{ config('app.supabase_url') }}/storage/v1/object/public/{{ env('SUPABASE_BUCKET') }}/{{ $pendaftar->$field }}"
                        target="_blank"
                        class="btn btn-sm {{ $info['color'] }} rounded-pill px-3 shadow-sm fw-bold text-xs">
                            <i class="bi bi-eye-fill me-1"></i> Lihat File
                        </a>
                    @else
                        <span class="badge bg-light text-muted border rounded-pill px-3 py-2 text-xs">
                            Kosong
                        </span>
                    @endif
                    </div>
                    @endforeach
                        </div>
                            <p class="text-muted small mb-4">Pastikan seluruh dokumen sesuai dengan identitas calon siswa sebelum proses verifikasi dan pembuatan akun dilakukan.</p>
                        </div>
                 </div>
            </div>
     </div>