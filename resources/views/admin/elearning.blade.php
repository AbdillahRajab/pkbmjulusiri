@php
    if (!isset($total_pendaftar)) {
        $total_pendaftar = 0;
    }
    if (!isset($total_siswa)) {
        $total_siswa = 0;
    }
    if (!isset($total_tutor)) {
        $total_tutor = 0;
    }
    if (!isset($total_admin)) {
        $total_admin = 0;
    }
    if (!isset($data_siswa)) {
        $data_siswa = collect();
    }
    if (!isset($daftar_kelas)) {
        $daftar_kelas = collect();
    }
@endphp
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard E-Learning - PKBM JULU SIRI</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .sidebar {
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 100;
            width: 260px;
            background-color: #001f3f;
        }

        .sidebar .nav-link {
            font-weight: bold;
            color: #b8c7ce;
            padding: 12px 20px;
            border-radius: 4px;
            margin: 2px 10px;
            display: flex;
            align-items: center;
            text-decoration: none;
            cursor: pointer;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background-color: rgba(255, 255, 255, 0.1);
            color: #fff;
        }

        .sidebar .nav-link.active {
            background-color: #003366;
        }

        .sidebar-heading {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: .1rem;
            font-weight: bold;
            color: #6c757d;
            padding: 15px 20px 5px;
        }

        .main-content {
            margin-left: 260px;
            padding-top: 100px;
        }

        .navbar-top {
            background-color: #ffffff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.04);
            left: 260px;
            width: calc(100% - 260px);
        }

        .nav-pills .nav-link,
        .sidebar .nav-link,
        .nav-item .nav-link {
            transition: all 0.3s ease;
            color: #495057;
        }

        .nav-pills .nav-link:hover,
        .sidebar .nav-link:hover,
        .nav-item .nav-link:hover {
            background-color: #f8f9fa !important;
            /* Warna latar belakang jadi terang/abu-abu halus */
            color: #0d6efd !important;
            /* Warna teks/ikon berubah jadi biru cerah */
            padding-left: 20px !important;
            /* Efek geser sedikit ke kanan biar estetik */
            font-weight: bold;
        }

        .bg-dark .nav-link:hover,
        .sidebar-dark .nav-link:hover {
            background-color: #212529 !important;
            /* Latar belakang abu-abu gelap */
            color: #ffffff !important;
            /* Teks jadi putih bersih */
            padding-left: 20px !important;
        }

        .nav-pills .nav-link.active,
        .sidebar .nav-link.active {
            background-color: #0d6efd !important;
            /* Warna biru saat aktif */
            color: white !important;
        }
    </style>
</head>

<body>

    <!-- SIDEBAR KIRI -->
    <div class="sidebar">
        <div class="text-center py-4 border-bottom border-secondary">
            <img src="{{ asset('images/logo3.png') }}" alt="Logo PKBM" width="40" height="40"
                class="d-inline-block align-top img-fluid">
            <h5 class="text-white fw-bold mb-0">PKBM JULU SIRI</h5>
            <small class="text-warning font-monospace" style="font-size: 0.75rem;">PANEL
                {{ strtoupper(Auth::user()->role) }}</small>
        </div>

        <div class="nav pt-3 gap-1" id="v-pills-tab" role="tablist" aria-orientation="vertical"
            style="max-height: calc(100vh - 140px); overflow-y: auto !important; overflow-x: hidden !important; display: block !important; width: 100% !important; padding-bottom: 50px;">

            <p class="sidebar-heading mb-1 px-3 small text-uppercase fw-bold text-white opacity-75"
                style="font-size: 11px; letter-spacing: 0.5px;">Menu Utama</p>
            <button class="nav-link border-0 text-start bg-transparent text-white w-100 d-block mb-2 active"
                id="tab-dashboard" data-bs-toggle="pill" data-bs-target="#panel-dash" type="button" role="tab">
                <i class="bi bi-speedometer2 me-3"></i> Dashboard
            </button>

            @if (Auth::user()->role == 'admin')
                <p class="sidebar-heading mb-1 mt-3 px-3 small text-uppercase fw-bold text-white opacity-75"
                    style="font-size: 11px; letter-spacing: 0.5px;">Kelola Pendaftar</p>
                <button class="nav-link border-0 text-start bg-transparent text-info w-100 d-block mb-2"
                    id="tab-pendaftar" data-bs-toggle="pill" data-bs-target="#panel-pendaftar" type="button"
                    role="tab">
                    <i class="bi bi-clipboard2-check-fill me-3"></i> Data Pendaftar
                </button>

                <p class="sidebar-heading mb-1 mt-3 px-3 small text-uppercase fw-bold text-white opacity-75"
                    style="font-size: 11px; letter-spacing: 0.5px;">Manajemen Pengguna</p>
                <button class="nav-link border-0 text-start bg-transparent text-warning w-100 d-block mb-1"
                    id="tab-admin" data-bs-toggle="pill" data-bs-target="#panel-user" type="button" role="tab">
                    <i class="bi bi-shield-lock-fill me-3"></i> Data User
                </button>
                <button class="nav-link border-0 text-start bg-transparent text-success w-100 d-block mb-1"
                    id="tab-tutor" data-bs-toggle="pill" data-bs-target="#panel-tutor" type="button" role="tab">
                    <i class="bi bi-person-badge-fill me-3"></i> Data Tutor
                </button>
                <button class="nav-link border-0 text-start bg-transparent text-white w-100 d-block mb-2" id="tab-siswa"
                    data-bs-toggle="pill" data-bs-target="#panel-siswa" type="button" role="tab">
                    <i class="bi bi-people-fill me-3"></i> Data Warga Belajar
                </button>

                <p class="sidebar-heading mb-1 mt-3 px-3 small text-uppercase fw-bold text-white opacity-75"
                    style="font-size: 11px; letter-spacing: 0.5px;">Kelola Akademik</p>
                <button class="nav-link border-0 text-start bg-transparent text-white w-100 d-block mb-1" id="tab-kelas"
                    data-bs-toggle="pill" data-bs-target="#panel-kelas" type="button" role="tab">
                    <i class="bi bi-houses-fill me-3 text-warning"></i> Ruang Kelas
                </button>
                <button class="nav-link border-0 text-start bg-transparent text-white w-100 d-block mb-1"
                    id="tab-berita" data-bs-toggle="pill" data-bs-target="#panel-berita" type="button" role="tab">
                    <i class="bi bi-newspaper me-3 text-warning"></i> Berita & Info
                </button>
        </div>


        {{-- HALAMAN TUTOR --}}
    @elseif(Auth::user()->role == 'tutor')
        <p class="sidebar-heading mb-1">Akademik Tutor</p>
        <button class="nav-link border-0 text-start bg-transparent text-white" id="tab-jadwal-tutor"
            data-bs-toggle="pill" data-bs-target="#panel-jadwal-tutor" type="button" role="tab"><i
                class="bi bi-calendar-event me-3"></i> Profil Tutor</button>
        <button class="nav-link border-0 text-start bg-transparent text-white w-100 d-block mb-1" id="tab-kelas-tutor"
            data-bs-toggle="pill" data-bs-target="#panel-kelas-tutor" type="button">
            <i class="bi bi-book-half me-3 text-warning"></i>
            Kelas Pembelajaran
        </button>
        <button class="nav-link border-0 text-start bg-transparent text-white" id="tab-berita" data-bs-toggle="pill"
            data-bs-target="#panel-berita" type="button">
            <i class="bi bi-newspaper me-3 text-info"></i>
            Berita PKBM
        </button>

        {{-- HALAMAN  SISWA --}}
    @elseif(Auth::user()->role == 'siswa')
        <p class="sidebar-heading mb-1">Ruang Belajar</p>
        <button class="nav-link border-0 text-start bg-transparent text-white" id="tab-kelas-siswa"
            data-bs-toggle="pill" data-bs-target="#panel-kelas-siswa" type="button" role="tab"><i
                class="bi bi-house-door-fill me-3"></i> Kelas Pembelajaran</button>
        <button class="nav-link border-0 text-start bg-transparent text-warning" data-bs-toggle="pill"
            data-bs-target="#panel-kelas-saya">
            <i class="bi bi-journal-bookmark-fill me-3"></i>Kelas Saya</button>
        <button class="nav-link border-0 text-start bg-transparent text-white"id="tab-profil-siswa"
            data-bs-toggle="pill" data-bs-target="#panel-profil-siswa"type="button">
            <i class="bi bi-person-circle me-3 text-success"></i>Profil Saya</button>
        <button class="nav-link border-0 text-start bg-transparent text-white"id="tab-berita"
            data-bs-toggle="pill"data-bs-target="#panel-berita" type="button">
            <i class="bi bi-newspaper me-3 text-info"></i>Berita PKBM
        </button>
        @endif
    </div>
    </div>

    <!-- NAVBAR ATAS -->
    <nav class="navbar navbar-expand-md navbar-top fixed-top p-0">
        <div class="container-fluid px-4 py-2 d-flex justify-content-between align-items-center">
            <span class="navbar-text fw-semibold text-dark"><i class="bi bi-calendar3 me-2"></i> Portal Pembelajaran
                PKBM JULU SIRI</span>
            <div class="dropdown">
                <button class="btn btn-light btn-sm dropdown-toggle fw-bold" type="button"
                    data-bs-toggle="dropdown">
                    <i class="bi bi-person-circle text-primary"></i> {{ Auth::user()->name }}
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                    <li>
                        <form action="{{ route('logout') }}" method="POST" class="px-2">
                            @csrf
                            <button type="submit" class="btn btn-danger btn-sm w-100 text-start rounded"><i
                                    class="bi bi-box-arrow-right me-2"></i> Keluar Sistem</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show mt-3">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                {{ session('error') }}

                <button type="button" class="btn-close" data-bs-dismiss="alert">
                </button>
            </div>
        @endif
    </nav>

    <!-- AREA KONTEN UTAMA -->
    <div class="main-content px-4 py-3">

        <!-- Notifikasi Sukses / Gagal Verifikasi -->
        @if (session('sukses_data'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('sukses_data') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="tab-content" id="v-pills-tabContent">

            <!-- PANEL DASHBOARD COMNAL -->
            <div class="tab-pane fade show active pt-3" id="panel-dash" role="tabpanel">
                <div class="card border-0 p-4 rounded-3 shadow-sm bg-white mb-4 mt-2">
                    <h3 class="fw-bold text-dark mb-1">Selamat Datang di Portal Utama, {{ Auth::user()->name }}!</h3>
                    <p class="text-muted mb-0">Otoritas Akses Anda: <span
                            class="badge bg-dark">{{ strtoupper(Auth::user()->role) }}</span></p>
                    <div class="row mb-4"></div>
                </div>


                @if (Auth::user()->role !== 'admin')
                    <div class="card border-0 shadow-sm rounded-3 bg-white p-4">
                        <h5 class="fw-bold text-primary"><i class="bi bi-megaphone-fill me-2"></i> Pengumuman Akademik
                            Terbaru</h5>
                        <hr class="text-muted">
                        <p class="text-secondary small mb-1"><strong>Diposting Oleh:</strong> Admin Sistem</p>
                        <p class="mb-0 text-dark">Selamat bergabung di Aplikasi E-Learning PKBM JULU SIRI. Silakan
                            periksa menu navigasi di sebelah kiri Anda untuk mengakses sistem pembelajaran.</p>
                    </div>
                @endif

                @if (Auth::user()->role == 'admin')
                    <div class="row g-3 mt-3">
                        <div class="col-md-3">
                            <div
                                class="card border-0 bg-white p-3 rounded-3 shadow-sm d-flex flex-row align-items-center justify-content-between">
                                <div><small class="text-muted fw-bold">CALON PENDAFTAR</small>
                                    <h3 class="fw-bold mb-0 text-danger">{{ $total_pendaftar }} Orang</h3>
                                </div>
                                <div class="bg-danger bg-opacity-10 text-danger p-3 rounded-3"><i
                                        class="bi bi-clipboard2-data fs-3"></i></div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div
                                class="card border-0 bg-white p-3 rounded-3 shadow-sm d-flex flex-row align-items-center justify-content-between">
                                <div><small class="text-muted fw-bold">WARGA BELAJAR</small>
                                    <h3 class="fw-bold mb-0 text-primary">{{ $total_siswa }} Siswa</h3>
                                </div>
                                <div class="bg-primary bg-opacity-10 text-primary p-3 rounded-3"><i
                                        class="bi bi-people fs-3"></i></div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div
                                class="card border-0 bg-white p-3 rounded-3 shadow-sm d-flex flex-row align-items-center justify-content-between">
                                <div><small class="text-muted fw-bold">TOTAL TUTOR</small>
                                    <h3 class="fw-bold mb-0 text-success">{{ $total_tutor }} Pengajar</h3>
                                </div>
                                <div class="bg-success bg-opacity-10 text-success p-3 rounded-3"><i
                                        class="bi bi-person-workspace fs-3"></i></div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card border-0 bg-white p-3 rounded-3 shadow-sm d-flex flex-row align-items-center justify-content-between">
                                <div><small class="text-muted fw-bold">TOTAL ADMIN</small>
                                    <h3 class="fw-bold mb-0 text-warning">{{ $total_admin }} User</h3>
                                </div>
                                <div class="bg-warning bg-opacity-10 text-warning p-3 rounded-3"><i class="bi bi-shield-lock fs-3"></i></div>
                            </div>
                                </div>
                            <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-0 shadow-sm rounded-4 h-100">
                                <div class="card-body d-flex justify-content-between align-items-center">
                                    <div>
                                        <div class="text-muted fw-bold text-uppercase small">
                                            Total Kelas
                                        </div>
                                        <div class="fs-1 fw-bold text-primary">
                                            {{ $total_kelas }}
                                        </div>
                                        <small class="text-secondary">
                                            Kelas Aktif
                                        </small>
                                    </div>
                                    <div class="bg-primary bg-opacity-10 rounded-4 p-3">
                                        <i class="bi bi-journal-bookmark-fill text-primary fs-2"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-0 shadow-sm rounded-4 h-100">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <div class="text-muted fw-bold text-uppercase small">
                                    Total Berita
                                </div>

                                <div class="fs-1 fw-bold text-success">
                                    {{ $total_berita }}
                                </div>

                                <small class="text-secondary">
                                    Berita Dipublikasikan
                                </small>
                            </div>

                            <div class="bg-success bg-opacity-10 rounded-4 p-3">
                                <i class="bi bi-newspaper text-success fs-2"></i>
                            </div>

                        </div>
                    </div>
                </div>
                    </div>
                    @endif
                @if(Auth::user()->role == 'admin')
                <div class="card border-0 shadow-sm rounded-4 mt-4">
                    <div class="card-body">
                        <h5 class="fw-bold mb-4">
                            <i class="bi bi-bar-chart-fill text-primary me-2"></i>
                            Grafik Statistik PKBM JULU SIRI
                        </h5>
                        <canvas id="grafikStatistik" height="90"></canvas>
                    </div>
                </div>
                @endif
            </div>

            @if (Auth::user()->role == 'admin')
                <!-- TABEL DATA TUTOR  -->
                <div class="tab-pane fade" id="panel-tutor" role="tabpanel">
                    <div class="card border-0 p-4 rounded-3 shadow-sm bg-white mt-4">
                        <h5 class="fw-bold mb-3 text-dark">
                            <i class="bi bi-person-badge-fill text-success me-2"></i>
                            Tabel Data Tenaga Pengajar / Tutor
                        </h5>
                        @if (session('success_tutor'))
                            <div class="alert alert-success alert-dismissible fade show">
                                <i class="bi bi-check-circle-fill me-2"></i>
                                {{ session('success_tutor') }}
                                <button class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif
                        <div class="table-responsive">
                            <table class="table table-striped table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Tutor</th>
                                        <th>Alamat Email</th>
                                        <th>Bidang Keahlian</th>
                                        <th>No WhatsApp</th>
                                        <th>Role</th>
                                        <th width="120">Aksi</th>
                                    </tr>
                                </thead>
                                @forelse($data_tutor as $key => $t)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td class="fw-bold text-success">
                                            {{ $t->name }}
                                        </td>
                                        <td>
                                            {{ $t->email }}
                                        </td>
                                        <td>
                                            @if ($t->bidang_keahlian)
                                                <span class="badge bg-info">
                                                    {{ $t->bidang_keahlian }}
                                                </span>
                                            @else
                                                <span class="text-muted">
                                                    -
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            {{ $t->no_whatsapp ?: '-' }}
                                        </td>
                                        <td>
                                            <span class="badge bg-success">
                                                Tutor
                                            </span>
                                        </td>
                                        <td>
                                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#editTutor{{ $t->id }}">
                                                <i class="bi bi-pencil-square"></i>
                                                Edit
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center text-muted py-3">
                                            Belum ada akun tutor yang terdaftar.
                                        </td>
                                    </tr>
                                @endforelse
                                @foreach ($data_tutor as $t)
                                    <div class="modal fade" id="editTutor{{ $t->id }}" tabindex="-1">
                                        <div class="modal-dialog">
                                            <form action="/tutor/{{ $t->id }}/update" method="POST">
                                                @csrf
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Edit Profil Tutor</h5>
                                                        <button type="button" class="btn-close"
                                                            data-bs-dismiss="modal">
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label>Nama Tutor</label>
                                                            <input type="text" name="name" class="form-control"
                                                                value="{{ $t->name }}">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label>Email</label>
                                                            <input type="email" name="email" class="form-control"
                                                                value="{{ $t->email }}">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label>Bidang Keahlian</label>
                                                            <input type="text" name="bidang_keahlian"
                                                                class="form-control"
                                                                value="{{ $t->bidang_keahlian }}">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label>No WhatsApp</label>
                                                            <input type="text" name="no_whatsapp"
                                                                class="form-control" value="{{ $t->no_whatsapp }}">
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button class="btn btn-success">
                                                            Simpan Perubahan
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- TABEL DATA USER --}}

                <div class="tab-pane fade" id="panel-user" role="tabpanel">
                    <div class="card border-0 p-4 rounded-3 shadow-sm bg-white mt-4">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <div>{{ $error }}</div>
                                @endforeach
                            </div>
                        @endif
                        <h5 class="fw-bold mb-3 text-dark"><i
                                class="bi bi-shield-lock-fill text-warning me-2"></i>Tabel Data USER</h5>
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show mb-3" role="alert"
                                style="color: #155724; background-color: #d4edda; border-color: #c3e6cb; padding: 12px; border-radius: 6px;">
                                <strong>Sukses!</strong> {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"
                                    style="float: right; background: none; border: none; font-size: 20px; font-weight: bold; opacity: .5; cursor: pointer;">×</button>
                            </div>
                        @endif
                        <button class="btn btn-warning mb-3" data-bs-toggle="modal"
                            data-bs-target="#modalTambahUser">
                            <i class="bi bi-plus-circle"></i> Tambah User
                        </button>
                        <div class="table-responsive">
                            <table class="table table-bordered align-middle">
                                <thead class="table-warning">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama user</th>
                                        <th>Alamat Email</th>
                                        <th>Role</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($data_user as $key => $usr)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td class="fw-bold text-dark">{{ $usr->name }}</td>
                                            <td>{{ $usr->email }}</td>
                                            <td>{{ $usr->role }}</td>
                                            <td class="text-center">
                                                <button class="btn btn-secondary btn-xs py-1 px-2 text-xs fw-bold me-1"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#modalEditUser{{ $usr->id }}">
                                                    <i class="bi bi-pencil-square"></i> Edit
                                                </button>

                                                <form action="{{ route('admin.user.destroy', $usr->id) }}"
                                                    method="POST" class="d-inline m-0"
                                                    onsubmit="return confirm('Yakin ingin menghapus pengguna {{ $usr->name }}?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="btn btn-danger btn-xs py-1 px-2 text-xs fw-bold">
                                                        <i class="bi bi-trash"></i> Hapus
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center text-muted py-3">Belum ada admin.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                @foreach ($data_user as $usr)
                    <div class="modal fade" id="modalEditUser{{ $usr->id }}" data-bs-backdrop="static"
                        tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title fw-bold"><i
                                            class="bi bi-pencil-square text-warning me-2"></i>Edit Data User</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <form action="{{ route('admin.user.update', $usr->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-body">
                                        <div class="form-group mb-3">
                                            <label class="fw-bold text-dark mb-1">Nama User</label>
                                            <input type="text" name="name" class="form-control"
                                                value="{{ $usr->name }}" required>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label class="fw-bold text-dark mb-1">Alamat Email</label>
                                            <input type="email" name="email" class="form-control"
                                                value="{{ $usr->email }}" required>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label class="fw-bold text-dark mb-1">Password Baru <small
                                                    class="text-muted">(Kosongkan jika tidak diganti)</small></label>
                                            <input type="password" id="password" name="password"
                                                class="form-control">
                                            <div class="invalid-feedback" id="passwordError"></div>
                                            {{-- <input type="password" name="password" class="form-control" placeholder="Masukkan password baru"> --}}
                                        </div>
                                        <div class="form-group mb-3">
                                            <label class="fw-bold text-dark mb-1">Role / Hak Akses</label>
                                            <select name="role" class="form-control" required>
                                                <option value="admin" {{ $usr->role == 'admin' ? 'selected' : '' }}>
                                                    Admin</option>
                                                <option value="tutor" {{ $usr->role == 'tutor' ? 'selected' : '' }}>
                                                    Tutor</option>
                                                <option value="siswa" {{ $usr->role == 'siswa' ? 'selected' : '' }}>
                                                    Siswa</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-warning text-white fw-bold">Simpan
                                            Perubahan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
                {{-- Modal tambah data user --}}
                <div class="modal fade" id="modalTambahUser" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form
                                action="{{ method_exists(Route::class, 'has') && Route::has('register') ? route('register') : url('/register') }}"
                                method="POST">
                                @csrf
                                <div class="modal-header">
                                    <h5 class="modal-title">Tambah User</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label>Nama</label>
                                        <input type="text" name="name" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label>Email</label>
                                        <input type="email" name="email" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label>Password</label>
                                        <input type="password" name="password" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label>Konfirmasi Password</label>
                                        <input type="password" name="password_confirmation"class="form-control"
                                            required>
                                    </div>
                                    <div class="mb-3">
                                        <label>Role</label>
                                        <select name="role" class="form-select">
                                            <option value="admin">Admin</option>
                                            <option value="tutor">Tutor</option>
                                            <option value="tutor">Siswa</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-warning">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>


                <!-- TABEL DATA PENDAFTAR ) -->
                <div class="tab-pane fade" id="panel-pendaftar" role="tabpanel">
                    <div class="card border-0 p-4 rounded-3 shadow-sm bg-white mt-4">
                        <h5 class="fw-bold mb-3 text-dark"><i
                                class="bi bi-clipboard2-check-fill text-info me-2"></i>Manajemen Calon Siswa Baru</h5>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover align-middle">
                                @if (session()->has('status_update'))
                                    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm my-3"
                                        role="alert"
                                        style="border-radius: 10px; background-color: #d1e7dd; color: #0f5132;">
                                        <i class="bi bi-check-circle-fill me-2"></i>
                                        <strong>Berhasil!</strong> {{ session('status_update') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>
                                @endif
                                @if (session('success_pendaftar'))
                                    <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
                                        <strong>Sukses!</strong> {{ session('success_pendaftar') }}

                                        <button
                                            type="button"
                                            class="btn-close"
                                            data-bs-dismiss="alert"
                                            aria-label="Close">
                                        </button>
                                    </div>
                                @endif
                                <thead class="table-dark">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Lengkap</th>
                                        <th>Pilihan Paket</th>
                                        <th>Status Berkas</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($data_pendaftar as $key => $p)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td class="fw-bold text-dark">{{ $p->nama }}</td>
                                            <td><span
                                                    class="badge bg-secondary">{{ strtoupper($p->paket ?? 'Paket C') }}</span>
                                            </td>
                                            <td>
                                                @if ($p->status == 'Diterima')
                                                    <span class="badge bg-success rounded-pill px-3 py-2">
                                                        <i class="bi bi-check-circle-fill me-1"></i>
                                                        Diterima
                                                    </span>
                                                @elseif($p->status == 'Ditolak')
                                                    <span class="badge bg-danger rounded-pill px-3 py-2">
                                                        <i class="bi bi-x-circle-fill me-1"></i>
                                                        Ditolak
                                                    </span>
                                                @else
                                                    <span class="badge bg-warning text-dark rounded-pill px-3 py-2">
                                                        <i class="bi bi-hourglass-split me-1"></i>
                                                        Pending
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.pendaftaran.show', $p->id) }}"
                                                    class="btn btn-primary btn-sm rounded-pill">
                                                    <i class="bi bi-search me-1"></i>
                                                    Detail Verifikasi
                                                </a>
                                                <form action="{{ route('admin.pendaftaran.destroy', $p->id) }}"
                                                    method="POST" class="d-inline m-0"
                                                    onsubmit="return confirm('Yakin ingin menghapus pendaftar {{ $p->nama }}?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <form
                                                        action="{{ route('admin.pendaftaran.destroy', $p->id) }}"method="POST"
                                                        class="d-inline"
                                                        onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-outline-danger btn-sm rounded-pill">
                                                            <i class="bi bi-trash"></i>
                                                        </button>

                                                    </form>
                                                </form>
                                        </div>
                                    </td>
                            </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-3">Belum ada data
                                formulir pendaftar masuk.</td>
                        </tr>
            @endforelse
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    // 1. Cek apakah ada tab aktif yang disimpan di memori browser (localStorage)
                    var activeTab = localStorage.getItem('activeAdminTab');
                    if (activeTab) {
                        var tabElement = document.querySelector('button[data-bs-target="' + activeTab + '"]') ||
                            document.querySelector('a[href="' + activeTab + '"]');
                        if (tabElement) {
                            var tab = new bootstrap.Tab(tabElement);
                            tab.show();
                        }
                    }

                    // 2. Simpan tab baru ke memori browser setiap kali Admin mengklik sidebar / tab lain
                    var tabTriggerList = [].slice.call(document.querySelectorAll(
                        '[data-bs-toggle="tab"], [data-bs-toggle="pill"]'));
                    tabTriggerList.forEach(function(tabTriggerEl) {
                        tabTriggerEl.addEventListener('shown.bs.tab', function(event) {
                            var targetId = event.target.getAttribute('data-bs-target') || event.target
                                .getAttribute('href');
                            localStorage.setItem('activeAdminTab', targetId);
                        });
                    });
                });
            </script>
            </tbody>
            </table>
        </div>
    </div>
    </div>
    @endif

<!-- TABEL DATA SISWA -->
<div class="tab-pane fade" id="panel-siswa" role="tabpanel">
    <div class="card border-0 p-4 rounded-3 shadow-sm bg-white mt-4">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="fw-bold text-dark mb-0">
                <i class="bi bi-people-fill text-primary me-2"></i>
                Tabel Data Warga Belajar
            </h5>

            <a href="{{ route('admin.siswa.import') }}" class="btn btn-success">
                <i class="bi bi-file-earmark-excel"></i>
                Import File Excel
            </a>
        </div>
    <div class="row mb-3">
        <div class="col-md-5">
            <input
                type="text"
                id="cariSiswa"
                class="form-control"
                placeholder="🔍 Cari berdasarkan Nama, NIS atau Kelas...">
        </div>
    </div>
        <div class="table-responsive">
            <table id="tabelSiswa" class="table table-bordered table-hover align-middle">
                <thead class="table-primary">
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>NIS</th>
                    <th>JK</th>
                    <th>Alamat</th>
                    <th>Tgl Lahir</th>
                    <th>Kelas</th>
                    <th>Status Akun</th>
                    <th>Aksi</th>
                </tr>
            </thead>
               <tbody id="bodySiswa">
                @forelse($data_siswa as $key => $s)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $s->nama }}</td>
                    <td>{{ $s->nis }}</td>
                    <td>{{ $s->jenis_kelamin }}</td>
                    <td>{{ $s->alamat }}</td>
                    <td>
                        @if($s->tgl_lahir)
                            {{ \Carbon\Carbon::parse($s->tgl_lahir)->format('d-m-Y') }}
                        @endif
                    </td>
                    <td>{{ $s->kelas }}</td>
                    <td>
                    @if($s->status_akun)
                        <span class="badge bg-success">
                            Aktif
                        </span>
                    @else
                        <span class="badge bg-danger">
                            Belum Aktif
                        </span>
                    @endif
                </td>
                    <td class="text-center">
                    <a href="#"
                        class="btn btn-info btn-sm btn-detail"
                        data-bs-toggle="modal"
                        data-bs-target="#detailSiswa"

                        data-nama="{{ $s->nama }}"
                        data-nis="{{ $s->nis }}"
                        data-jk="{{ $s->jenis_kelamin }}"
                        data-tempat="{{ $s->tempat_lahir }}"
                        data-tgl="{{ $s->tgl_lahir }}"
                        data-nik="{{ $s->nik }}"
                        data-agama="{{ $s->agama }}"
                        data-alamat="{{ $s->alamat }}"
                        data-kelurahan="{{ $s->kelurahan_desa }}"
                        data-kecamatan="{{ $s->kecamatan }}"
                        data-ayah="{{ $s->nama_ayah }}"
                        data-nikayah="{{ $s->nik_ayah }}"
                        data-ibu="{{ $s->nama_ibu }}"
                        data-nikibu="{{ $s->nik_ibu }}"
                        data-kelas="{{ $s->kelas }}"
                        data-status="{{ $s->status_akun }}"

                        title="Detail">
                        <i class="bi bi-eye-fill"></i>
                    </a>
                        @if($s->status_akun == 0)
                        <form action="{{ route('admin.siswa.aktifkan', $s->id) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit"
                                    class="btn btn-success btn-sm"
                                    title="Aktifkan Akun">
                                <i class="bi bi-person-check-fill"></i>
                            </button>
                        </form>
                        @else
                            <span class="badge bg-success">
                                Aktif
                            </span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center">
                        Belum ada data siswa.
                    </td>
                </tr>
                @endforelse
           </tbody>
        </table>
        </div>
    </div>
</div>

<!-- ================= MODAL DETAIL SISWA ================= -->

<div class="modal fade" id="detailSiswa" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    Detail Data Warga Belajar
                </h5>
                <button class="btn-close btn-close-white"
                        data-bs-dismiss="modal">
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered">
                    <tr>
                        <th width="35%">Nama</th>
                        <td id="detailNama"></td>
                    </tr>
                    <tr>
                        <th>NIS</th>
                        <td id="detailNis"></td>
                    </tr>
                    <tr>
                        <th>Jenis Kelamin</th>
                        <td id="detailJk"></td>
                    </tr>
                    <tr>
                        <th>Tempat Lahir</th>
                        <td id="detailTempat"></td>
                    </tr>
                    <tr>
                        <th>Tanggal Lahir</th>
                        <td id="detailTgl"></td>
                    </tr>
                    <tr>
                        <th>NIK</th>
                        <td id="detailNik"></td>
                    </tr>
                    <tr>
                        <th>Agama</th>
                        <td id="detailAgama"></td>
                    </tr>
                    <tr>
                        <th>Alamat</th>
                        <td id="detailAlamat"></td>
                    </tr>
                    <tr>
                        <th>Kelurahan</th>
                        <td id="detailKelurahan"></td>
                    </tr>
                    <tr>
                        <th>Kecamatan</th>
                        <td id="detailKecamatan"></td>
                    </tr>
                    <tr>
                        <th>Nama Ayah</th>
                        <td id="detailAyah"></td>
                    </tr>
                    <tr>
                        <th>NIK Ayah</th>
                        <td id="detailNikAyah"></td>
                    </tr>
                    <tr>
                        <th>Nama Ibu</th>
                        <td id="detailIbu"></td>
                    </tr>
                    <tr>
                        <th>NIK Ibu</th>
                        <td id="detailNikIbu"></td>
                    </tr>
                    <tr>
                        <th>Kelas</th>
                        <td id="detailKelas"></td>
                    </tr>
                    <tr>
                        <th>Status Akun</th>
                        <td id="detailStatus"></td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary"
                        data-bs-dismiss="modal">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>


    {{-- PANEL KELAS --}}
    <div class="tab-pane fade" id="panel-kelas">
        @if (session('success_kelas'))
            <div class="alert alert-success alert-dismissible fade show mt-5" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>
                {{ session('success_kelas') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                </button>
            </div>
        @endif
        <div class="card border-0 p-4 rounded-3 shadow-sm bg-white mt-4">
            <h5 class="fw-bold mb-3 text-dark">
                <i class="bi bi-houses-fill text-warning me-2"></i>Manajemen Ruang Kelas
            </h5>
            <p class="text-muted small">
                Konten manajemen ruang kelas hasil request tutor diletakkan di sini. Anda dapat membuat
                kelas baru dan menunjuk Tutor yang bertanggung jawab.
            </p>

            <button class="btn btn-primary btn-sm rounded-2 mt-2" data-bs-toggle="modal"
                data-bs-target="#modalTambahKelas" style="width: fit-content;">
                <i class="bi bi-plus-lg me-1"></i> Buat Kelas Baru (Request Tutor)
            </button>
        </div>

        <hr class="my-4">
        <h6 class="fw-bold mb-3">Daftar Kelas</h6>

        @forelse($data_kelas as $kelas)
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h5 class="fw-bold text-dark mb-2">
                                <i class="bi bi-book-half text-primary me-2"></i>
                                {{ $kelas->nama_kelas }}
                            </h5>
                            <p class="text-muted mb-2">
                                <i class="bi bi-person-badge-fill text-warning me-2"></i>
                                Tutor :
                                <strong>{{ $kelas->nama_tutor }}</strong>
                            </p>
                        </div>
                        <form action="{{ url('/admin/kelas/' . $kelas->id . '/hapus') }}" method="POST"
                            onsubmit="return confirm('Yakin ingin menghapus kelas ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-outline-danger btn-sm rounded-3">
                                <i class="bi bi-trash-fill"></i>
                            </button>
                        </form>
                    </div>

                    <hr>
                    <p class="text-secondary mb-4">
                        {{ $kelas->deskripsi }}
                    </p>

                    <div class="d-flex justify-content-between">

                        <small class="text-muted">
                            <i class="bi bi-calendar-event me-1"></i>
                            {{ \Carbon\Carbon::parse($kelas->created_at)->format('d M Y') }}
                        </small>

                    </div>
                </div>
            </div>

        @empty

            <div class="alert alert-warning">
                Belum ada kelas dibuat.
            </div>
        @endforelse

        <div class="modal fade" id="modalTambahKelas" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <form action="{{ route('admin.simpanKelas') }}" method="POST"
                    class="modal-content border-0 shadow-lg rounded-4">
                    @csrf
                    <div class="modal-header bg-dark text-white">
                        <h5 class="modal-title fw-bold">
                            <i class="bi bi-plus-circle me-2"></i>Buat Kelas Baru
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-secondary">Nama Kelas
                                Pembelajaran</label>
                            <input type="text" name="nama_kelas" class="form-control"
                                placeholder="Contoh: Matematika Paket C (Kelas XI)" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold text-secondary">Pilih Tutor /
                                Pengajar</label>
                            <select name="tutor_id" class="form-select" required>
                                <option value="">-- Pilih Tutor Penanggung Jawab --</option>
                                @php
                                    // Mengambil data user yang memiliki role tutor secara langsung
                                    $listTutor = \DB::select("SELECT id, name FROM users WHERE role = 'tutor'");
                                @endphp
                                @foreach ($listTutor as $tutor)
                                    <option value="{{ $tutor->id }}">{{ $tutor->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold text-secondary">Deskripsi atau
                                Instruksi</label>
                            <textarea name="deskripsi" class="form-control" rows="3"
                                placeholder="Tulis deskripsi ringkas atau aturan kelas..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Konfirmasi & Buat Kelas</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    {{-- BERITA & INFORMASI ADMIN --}}
    <div class="tab-pane fade" id="panel-berita" role="tabpanel">
        @if (Auth::user()->role == 'admin')
            @if (session('success_berita'))
                <div class="alert alert-success alert-dismissible fade show shadow-sm mt-5 mb-4 rounded-3">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    {{ session('success_berita') }}

                    <button type="button" class="btn-close" data-bs-dismiss="alert">
                    </button>
                </div>
            @endif
            <div class="card border-0 p-4 rounded-3 shadow-sm bg-white mt-4">

                <h5 class="fw-bold text-dark">
                    <i class="bi bi-megaphone-fill text-danger me-2"></i>
                    Berita & Informasi
                </h5>

                <p class="text-muted small">
                    Admin dapat membagikan pengumuman, informasi akademik, jadwal ujian,
                    maupun berita penting kepada Tutor dan Siswa.
                </p>

                <button class="btn btn-primary rounded-3 shadow-sm" data-bs-toggle="modal"
                    data-bs-target="#modalTambahBerita">
                    <i class="bi bi-plus-circle-fill me-2"></i>
                    Tambah Berita
                </button>

            </div>
            <hr class="my-4">
            <h6 class="fw-bold mb-3">
                Daftar Berita
            </h6>
            @forelse($data_berita as $berita)
                <div class="card border-0 shadow rounded-4 mb-4 overflow-hidden">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <span class="badge bg-danger rounded-pill px-3 py-2 mb-3">
                                    <i class="bi bi-megaphone-fill me-1"></i>
                                    Pengumuman
                                </span>
                                <h4 class="fw-bold mb-2">
                                    {{ $berita->judul }}
                                </h4>
                                <div class="text-muted small">
                                    <i class="bi bi-person-circle"></i>
                                    {{ $berita->nama_admin }}
                                    <span class="mx-2">•</span>
                                    <i class="bi bi-calendar-event"></i>
                                    {{ \Carbon\Carbon::parse($berita->created_at)->format('d M Y H:i') }}
                                </div>
                            </div>
                        </div>
                        <hr>
                        <p class="text-secondary fs-6 mb-4" style="line-height:1.8">
                            {{ $berita->isi }}
                        </p>
                        <div class="d-flex justify-content-end gap-2">
                            <form action="{{ route('admin.berita.hapus', $berita->id) }}" method="POST"
                                onsubmit="return confirm('Yakin ingin menghapus berita ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-outline-danger btn-sm rounded-3">
                                    <i class="bi bi-trash-fill"></i>
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty

                <div class="alert alert-warning rounded-4">
                    <i class="bi bi-info-circle-fill me-2"></i>
                    Belum ada berita yang dipublikasikan.
                </div>
            @endforelse
        @else
            <div class="card border-0 shadow-sm rounded-4 p-4 mt-4">
                <h4 class="fw-bold mb-4">
                    <i class="bi bi-newspaper text-primary me-2"></i>
                    Berita & Informasi PKBM
                </h4>
                @forelse($data_berita as $item)
                    <div class="card border-0 shadow-sm rounded-4 mb-4">
                        <div class="card-body">
                            <h5 class="fw-bold">
                                {{ $item->judul }}
                            </h5>
                            <small class="text-muted">
                                {{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('d F Y') }}
                            </small>
                            <p class="mt-3">
                                {{ Str::limit(strip_tags($item->isi), 200) }}
                            </p>
                        </div>
                    </div>
                @empty
                    <div class="alert alert-info">
                        Belum ada berita.
                    </div>
                @endforelse
            </div>
        @endif
    </div>


    {{-- HALAMAN TUTOR --}}
    <div class="tab-pane fade" id="panel-jadwal-tutor" role="tabpanel" aria-labelledby="tab-jadwal-tutor">
        <div class="card border-0 shadow-sm p-4 mt-4 bg-white rounded">
            <h5 class="fw-bold text-dark mb-4 pb-2 border-bottom">
                <i class="bi bi-person-circle me-2 text-primary"></i>Profil Resmi Tutor
            </h5>

            <div class="table-responsive">
                <table class="table table-borderless align-middle">
                    <tbody>
                        <tr class="border-bottom">
                            <td width="200" class="text-muted fw-semibold py-3">Nama Tutor:</td>
                            <td class="fw-bold text-dark py-3">{{ Auth::user()->name }}</td>
                        </tr>
                        <tr class="border-bottom">
                            <td class="text-muted fw-semibold py-3">Email Akun:</td>
                            <td class="text-secondary py-3">{{ Auth::user()->email }}</td>
                        </tr>
                        <tr class="border-bottom">
                            <td class="text-muted fw-semibold py-3">Bidang Keahlian:</td>
                            <td class="py-3">
                                @if (Auth::user()->bidang_keahlian)
                                    <span class="badge bg-info-subtle text-info px-2 py-1 fw-semibold">
                                        {{ Auth::user()->bidang_keahlian }}
                                    </span>
                                @else
                                    <span class="badge bg-secondary-subtle text-secondary px-2 py-1 fw-semibold">
                                        Belum Diatur Admin
                                    </span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="text-muted fw-semibold py-3">No. HP / WhatsApp:</td>
                            <td class="text-secondary py-3">
                                {{ Auth::user()->no_whatsapp ?? 'Belum diisi oleh Admin' }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- KELAS ELEARNING --}}
    <div class="tab-pane fade" id="panel-kelas-tutor">
        <div class="card border-0 shadow-sm p-4 mt-4 bg-white rounded">
            <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
                <div>
                    <h4 class="fw-bold text-dark mb-1">Ruang Kelas Pembelajaran</h4>
                    <p class="text-muted small mb-0">Kelola ruang belajar virtual dan distribusikan materi
                        bimbingan Anda di sini.</p>
                </div>
            </div>

            <h6 class="fw-bold text-secondary mb-3"><i class="bi bi-grid-3x3-gap-fill me-2 text-primary"></i>Daftar
                Kelas Aktif Anda</h6>
            <div id="konten-kelas-tutor" class="row g-3 mt-3">
            </div>

        </div>

        <div class="modal fade" id="modalUploadModulTutor" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <form action="#" method="POST" enctype="multipart/form-data"
                    class="modal-content border-0 shadow">
                    @csrf
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title fw-bold"><i class="bi bi-file-earmark-pdf me-2"></i>Upload
                            Modul Pembelajaran</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-secondary">Judul Modul</label>
                            <input type="text" name="judul_modul" class="form-control"
                                placeholder="Contoh: Modul 2 - Teks Deskripsi" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-secondary">Pilih File Dokumen (Wajib
                                PDF)</label>
                            <input type="file" name="file_modul" class="form-control" accept=".pdf" required>
                        </div>
                    </div>
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Mulai Upload</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="modal fade" id="modalBuatTugasTutor" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <form action="#" method="POST" enctype="multipart/form-data"
                    class="modal-content border-0 shadow">
                    @csrf
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title fw-bold"><i class="bi bi-pencil-square me-2"></i>Buat Tugas
                            Mandiri</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-secondary">Judul / Nama Tugas</label>
                            <input type="text" name="judul_tugas" class="form-control"
                                placeholder="Contoh: Lembar Kerja Siswa 1" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-secondary">Batas Pengumpulan
                                (Deadline)</label>
                            <input type="datetime-local" name="deadline" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-secondary">Upload Berkas Soal (Format
                                Bebas / Opsional)</label>
                            <input type="file" name="file_tugas" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">Bagikan Tugas</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- MODAL TAMBAH BERITA --}}
    <div class="modal fade" id="modalTambahBerita" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <form action="{{ route('admin.berita.simpan') }}" method="POST">
                @csrf
                <div class="modal-content border-0 shadow rounded-4">

                    <div class="modal-header border-0 pb-0">
                        <h5 class="modal-title fw-bold">
                            <i class="bi bi-megaphone-fill text-danger me-2"></i>
                            Publikasikan Berita Baru
                        </h5>

                        <button type="button" class="btn-close" data-bs-dismiss="modal">
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                Judul Berita
                            </label>
                            <input type="text" name="judul" class="form-control rounded-3"
                                placeholder="Contoh : Jadwal Ujian Semester Genap" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                Isi Berita
                            </label>
                            <textarea name="isi" rows="6" class="form-control rounded-3"
                                placeholder="Tuliskan isi pengumuman atau informasi akademik..." required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-light rounded-3" data-bs-dismiss="modal">
                            Batal
                        </button>
                        <button type="submit" class="btn btn-primary rounded-3">
                            <i class="bi bi-send-fill me-2"></i>
                            Publikasikan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- HALAMAN SISWA -->
    @if (Auth::user()->role == 'siswa')

        <div class="tab-pane fade" id="panel-kelas-siswa" role="tabpanel">
            <div class="card border-0 p-4 rounded-3 shadow-sm bg-white mt-4">

                <h5 class="fw-bold mb-4">
                    Kelas Pembelajaran
                </h5>
                <p>Total kelas: {{ count($data_kelas) }}</p>

                @forelse($data_kelas as $kelas)
                    <div class="card shadow-sm border-0 rounded-4 mb-4">
                        <div class="card-body">

                            <h4 class="fw-bold">
                                {{ $kelas->nama_kelas }}
                            </h4>

                            <p class="text-muted mb-2">
                                <i class="bi bi-person-badge-fill"></i>
                                Tutor : {{ $kelas->nama_tutor }}
                            </p>

                            <div class="mb-3">
                                <span class="badge bg-info">
                                    <i class="bi bi-people-fill"></i>
                                    {{ $kelas->jumlah_peserta }} Peserta
                                </span>
                            </div>

                            <p class="text-secondary">
                                {{ $kelas->deskripsi }}
                            </p>

                            @php
                                $sudahGabung = DB::table('peserta_kelas')
                                    ->where('kelas_id', $kelas->id)
                                    ->where('user_id', Auth::id())
                                    ->exists();
                            @endphp

                            @if ($sudahGabung)
                                <a href="{{ url('/ruang-kelas/' . $kelas->id) }}" class="btn btn-success">
                                    Masuk Kelas
                                </a>
                            @else
                                <button class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#modalGabung{{ $kelas->id }}">
                                    Gabung Kelas
                                </button>
                            @endif

                        </div>
                    </div>

                    <!-- MODAL GABUNG KELAS -->
                    <div class="modal fade" id="modalGabung{{ $kelas->id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <form action="{{ url('/ruang-kelas/' . $kelas->id . '/verifikasi') }}" method="POST">

                                @csrf

                                <div class="modal-content">

                                    <div class="modal-header">
                                        <h5 class="modal-title">
                                            Gabung Kelas
                                        </h5>
                                    </div>

                                    <div class="modal-body">

                                        <h5>{{ $kelas->nama_kelas }}</h5>

                                        <p class="text-muted">
                                            Tutor : {{ $kelas->nama_tutor }}
                                        </p>

                                        <div class="mb-3">
                                            <label>Password Kelas</label>

                                            <input type="password" name="password_masuk" class="form-control"
                                                placeholder="Masukkan Password Kelas" required>
                                        </div>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                            Batal
                                        </button>
                                        <button type="submit" class="btn btn-primary">
                                            Gabung
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="alert alert-warning">
                        Belum ada kelas tersedia.
                    </div>
                @endforelse
            </div>
        </div>

        {{-- PROFIL SISWA --}}
        <div class="tab-pane fade" id="panel-profil-siswa">
            <div class="card border-0 shadow rounded-4 mt-4">
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        <div class="col-md-3 text-center">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=0D6EFD&color=fff&size=200"
                                class="rounded-circle shadow mb-3" width="170" height="170">
                            <h5 class="fw-bold">
                                {{ Auth::user()->name }}
                            </h5>
                            <span class="badge bg-success">
                                Warga Belajar
                            </span>
                        </div>
                        <div class="col-md-9">
                            <h4 class="fw-bold mb-4">
                                <i class="bi bi-person-circle text-success me-2"></i>
                                Profil Saya
                            </h4>
                            <table class="table table-borderless">
                                <tr>
                                    <th width="180">Nama Lengkap</th>
                                    <td>{{ Auth::user()->name }}</td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td>{{ Auth::user()->email }}</td>
                                </tr>
                                <tr>
                                    <th>Role</th>
                                    <td>
                                        <span class="badge bg-primary">
                                            {{ strtoupper(Auth::user()->role) }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Bergabung Sejak</th>
                                    <td>
                                        {{ \Carbon\Carbon::parse(Auth::user()->created_at)->translatedFormat('d F Y') }}
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- PANEL KELAS SAYA --}}
        <div class="tab-pane fade" id="panel-kelas-saya" role="tabpanel">
            <div class="card border-0 p-4 rounded-3 shadow-sm bg-white mt-4">
                <h3 class="fw-bold mb-4"> Kelas Saya </h3>
                <p>Total kelas saya : {{ count($data_kelas_saya) }}</p>
                @forelse($data_kelas_saya as $kelas)
                    <div class="card shadow-sm border-0 rounded-4 mb-4">
                        <div class="card-body">
                            <h4 class="fw-bold">
                                {{ $kelas->nama_kelas }}
                            </h4>

                            <p class="text-muted mb-2">
                                <i class="bi bi-person-badge-fill"></i>
                                Tutor : {{ $kelas->nama_tutor }}
                            </p>

                            <span class="badge bg-info mb-3">
                                <i class="bi bi-people-fill"></i>
                                {{ $kelas->jumlah_peserta }} Peserta
                            </span>

                            <p class="text-secondary">
                                {{ $kelas->deskripsi }}
                            </p>
                            <a href="{{ url('/ruang-kelas/' . $kelas->id) }}" class="btn btn-success">
                                <i class="bi bi-box-arrow-in-right"></i>
                                Masuk Kelas
                            </a>
                        </div>
                    </div>

                @empty
                    <div class="alert alert-warning">
                        Anda belum mengikuti kelas apapun.
                    </div>
                @endforelse
            </div>
        </div>
    @endif

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @if(auth()->check() && auth()->user()->role == 'tutor')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            function muatKelasTutor() {
                fetch('/ambil-kelas-tutor')
                    .then(response => response.json())
                    .then(data => {
                        const wadah = document.getElementById('konten-kelas-tutor');
                        wadah.innerHTML = ''; // Bersihkan kontainer

                        if (data.length === 0) {
                            wadah.innerHTML = `
                                            <div class="col-12 text-center py-5">
                                                <img src="https://cdn-icons-png.flaticon.com/512/7486/7486744.png" alt="Kosong" style="width: 100px; opacity: 0.5;" class="mb-3">
                                                <h5 class="fw-bold text-dark mb-1">Belum Ada Kelas Aktif</h5>
                                                <p class="text-muted small">Mulai perjalanan mengajar Anda dengan menekan tombol "Buat Kelas Baru" di atas.</p>
                                            </div>`;
                            return;
                        }

                        data.forEach(kelas => {
                            wadah.innerHTML += `
                                            <div class="col-md-4">
                                                <div class="card border-0 shadow-sm rounded-4 h-100">
                                                    <div class="card-body p-4 d-flex flex-column justify-content-between">
                                                        <div>
                                                            <span class="badge bg-primary bg-opacity-10 text-primary mb-3 px-3 py-2 rounded-3">Kelas Aktif</span>
                                                            <h5 class="fw-bold text-dark mb-2">${kelas.nama_kelas}</h5>
                                                            <p class="text-muted small mb-4">${kelas.deskripsi ? kelas.deskripsi : ''}</p>
                                                        </div>
                                                        <a href="/ruang-kelas/${kelas.id}" class="btn btn-primary w-100 rounded-3 py-2 fw-semibold">
                                                            Buka Ruang Kelas <i class="bi bi-arrow-right ms-1"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>`;
                        });
                    });
            }

            // Jalankan fungsi saat halaman pertama kali dibuka
            muatKelasTutor();
        });
    </script>
    @endif
    <script>
        const password = document.getElementById('password');
        const error = document.getElementById('passwordError');

        password.addEventListener('input', function() {
            if (this.value.length > 0 && this.value.length < 4) {
                this.classList.add('is-invalid');
                error.textContent = 'Password minimal 4 karakter.';
            } else {
                this.classList.remove('is-invalid');
                error.textContent = '';
            }
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            if (window.location.hash) {
                const trigger = document.querySelector(
                    'button[data-bs-target="' + window.location.hash + '"]'
                );
                if (trigger) {
                    new bootstrap.Tab(trigger).show();
                }
            }
        });
    </script>
<script>
document.getElementById('cariSiswa').addEventListener('keyup', function () {
    let keyword = this.value.toLowerCase();
    let rows = document.querySelectorAll('#bodySiswa tr');
    rows.forEach(function(row){
        let nama  = row.cells[1].innerText.toLowerCase();
        let nis   = row.cells[2].innerText.toLowerCase();
        let kelas = row.cells[6].innerText.toLowerCase();
        if (
            nama.includes(keyword) ||
            nis.includes(keyword) ||
            kelas.includes(keyword)
        ){
            row.style.display = "";
        }else{
            row.style.display = "none";
        }
    });
});
</script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('grafikStatistik');
new Chart(ctx, {
    type: 'bar',
    data: {
        labels: [
            'Pendaftar',
            'Warga Belajar',
            'Tutor',
            'Admin',
            'Kelas',
            'Berita'
        ],
        datasets: [{
            label: 'Jumlah Data',
            data: [
                {{ $total_pendaftar }},
                {{ $total_siswa }},
                {{ $total_tutor }},
                {{ $total_admin }},
                {{ $total_kelas }},
                {{ $total_berita }}
            ],
            backgroundColor: [
                '#ef4444',
                '#2563eb',
                '#10b981',
                '#f59e0b',
                '#8b5cf6',
                '#06b6d4'
            ],
            borderRadius: 8,
            borderWidth: 0
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                display: false
            },
            title: {
                display: true,
                text: 'Statistik PKBM JULU SIRI Tahun {{ date("Y") }}',
                font: {
                    size: 18
                }
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    precision: 0
                }
            }
        }
    }
});
</script>
</body>

</html>
<script>
document.querySelectorAll('.btn-detail').forEach(function(btn){
    btn.addEventListener('click',function(){
        document.getElementById('detailNama').innerText=this.dataset.nama;
        document.getElementById('detailNis').innerText=this.dataset.nis;
        document.getElementById('detailJk').innerText=this.dataset.jk;
        document.getElementById('detailTempat').innerText=this.dataset.tempat;
        document.getElementById('detailTgl').innerText=this.dataset.tgl;
        document.getElementById('detailNik').innerText=this.dataset.nik;
        document.getElementById('detailAgama').innerText=this.dataset.agama;
        document.getElementById('detailAlamat').innerText=this.dataset.alamat;
        document.getElementById('detailKelurahan').innerText=this.dataset.kelurahan;
        document.getElementById('detailKecamatan').innerText=this.dataset.kecamatan;
        document.getElementById('detailAyah').innerText=this.dataset.ayah;
        document.getElementById('detailNikAyah').innerText=this.dataset.nikayah;
        document.getElementById('detailIbu').innerText=this.dataset.ibu;
        document.getElementById('detailNikIbu').innerText=this.dataset.nikibu;
        document.getElementById('detailKelas').innerText=this.dataset.kelas;

        if(this.dataset.status==1){
            document.getElementById('detailStatus').innerHTML='<span class="badge bg-success">Aktif</span>';
        }else{
            document.getElementById('detailStatus').innerHTML='<span class="badge bg-secondary">Belum Aktif</span>';

        }

    });

});

</script>
