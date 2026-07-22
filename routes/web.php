<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PendaftaranController;
use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Siswa;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| A. RUTE PUBLIK (Bebas Diakses Siapa Saja - TIDAK BOLEH MASUK MIDDLEWARE)
|--------------------------------------------------------------------------
*/
Route::get('/', function () {

    $jumlahSiswa = Siswa::count();

    $jumlahTutor = User::where('role','tutor')->count();

    $jumlahKelas = DB::table('kelas')->count();

    return view('welcome', compact(
        'jumlahSiswa',
        'jumlahTutor',
        'jumlahKelas'
    ));
});


// Tampilan Halaman Formulir Pendaftaran Publik
Route::get('/pendaftaran', function () {
    return view('pendaftaran.form');
})->name('pendaftaran.form');

// Proses Pengiriman Data Form Pendaftaran (POST)
Route::post('/pendaftaran/kirim', [PendaftaranController::class, 'store'])->name('pendaftaran.store');

// Tampilan Halaman Login Satu Pintu
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');

// Proses Validasi Autentikasi Login Akun
Route::post('/login', [AuthController::class, 'processLogin'])->name('login.process');

// Form Registrasi Akun Baru (Triple Aktor)
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.process');


/*
|--------------------------------------------------------------------------
| B. RUTE INTERNAL (Wajib Login - DILINDUNGI PENUH OLEH AUTH MIDDLEWARE)
|--------------------------------------------------------------------------
*/
    Route::middleware(['auth'])->group(function () {
    
    // GANTI BARIS INI: Alihkan rute utama elearning ke AdminController
    Route::get('/elearning', [AdminController::class, 'index'])->name('elearning.index');

    // Tambahkan Rute untuk memproses pengisian form kelola data admin
    Route::post('/elearning/tambah-kelas', [AdminController::class, 'storeKelas'])->name('admin.storeKelas');
    Route::post('/elearning/tambah-mapel', [AdminController::class, 'storeMapel'])->name('admin.storeMapel');
    Route::post('/elearning/tambah-tutor', [AdminController::class, 'storeTutor'])->name('admin.storeTutor');

    Route::get('/admin/promosi/{id}', [AdminController::class, 'jadikanAdmin']);
    Route::get('/admin/demosi/{id}', [AdminController::class, 'turunkanJabatan']);


    // Rute Verifikasi Berkas kemarin tetap biarkan ada
    Route::get('/verifikasi-berkas', [PendaftaranController::class, 'indexAdmin'])->name('admin.verifikasi');
    Route::get('/verifikasi-berkas/{id}/{status}', [PendaftaranController::class, 'ubahStatus'])->name('admin.verifikasi.status');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Rute untuk memproses pengiriman formulir pendaftaran siswa baru
    Route::post('/pendaftaran-siswa', [PendaftaranController::class, 'store'])->name('pendaftaran.store');

    Route::post('/admin/pendaftaran/{id}/status/{status}', [PendaftaranController::class, 'ubahStatus'])->name('admin.pendaftaran.status');
    Route::get('/admin/pendaftaran/{id}/edit', [PendaftaranController::class, 'edit'])->name('admin.pendaftaran.edit');
    Route::delete('/admin/pendaftaran/{id}', [PendaftaranController::class, 'destroy'])->name('admin.pendaftaran.destroy');


    // Pastikan baris rute ini ada di dalam group admin Anda
    Route::get('/admin/pendaftaran/{id}/lihat', [PendaftaranController::class, 'show'])->name('admin.pendaftaran.show');
    Route::put('/admin/pendaftaran/{id}', [PendaftaranController::class, 'update'])->name('admin.pendaftaran.update');
    Route::delete('/admin/pendaftaran/{id}', [PendaftaranController::class, 'destroy'])->name('admin.pendaftaran.destroy');
    Route::get('/admin/pendaftaran/{id}/cetak', [AdminController::class, 'cetakPendaftaran'])->name('admin.pendaftaran.cetak');
    
    // Rute untuk memproses Update data User
    Route::put('/admin/user/{id}/update', [App\Http\Controllers\PendaftaranController::class, 'userUpdate'])->name('admin.user.update');

    // Rute untuk memproses Hapus data User
    Route::delete('/admin/user/{id}/delete', [App\Http\Controllers\PendaftaranController::class, 'userDestroy'])->name('admin.user.destroy');

    Route::get('/admin/import-siswa', [AdminController::class, 'formImportSiswa'])
        ->name('admin.siswa.import');

    Route::post('/admin/import-siswa', [AdminController::class, 'importSiswa'])
        ->name('admin.siswa.import.proses');
        
    Route::post('/admin/siswa/{id}/aktifkan', [AdminController::class, 'aktifkanAkun'])
        ->name('admin.siswa.aktifkan');
        
    Route::post('/admin/berita/simpan', [AdminController::class, 'simpanBerita'])
    ->name('admin.berita.simpan');

    Route::delete('/admin/berita/{id}/hapus', [AdminController::class,'hapusBerita'])
    ->name('admin.berita.hapus');


    // Halaman edit berita
    Route::get('/admin/berita/{id}/edit', [AdminController::class, 'editBerita'])
    ->name('admin.berita.edit');

// Proses update berita
    Route::put('/admin/berita/{id}/update', [AdminController::class, 'updateBerita'])
    ->name('admin.berita.update');
    
    Route::post('/ruang-kelas/{id}/update-password', [AdminController::class, 'updatePasswordKelas'])
    ->name('kelas.updatePassword');

    // 1. Jalur POST: Mengupdate password kelas (Aksi dari modal tutor)
    Route::post('/ruang-kelas/{id}/verifikasi', function (Request $request, $id) {

    $passwordMasuk = $request->password_masuk;

    $kelas = DB::table('kelas')
        ->where('id', $id)
        ->first();

    if (!$kelas) {
        return back()->with('error', 'Kelas tidak ditemukan.');
    }

    if ($kelas->password_kelas != $passwordMasuk) {

    return redirect('/ruang-kelas/'.$id)
        ->with('error', 'Password kelas yang Anda masukkan salah. Silakan coba lagi.');
}
    // Cek apakah siswa sudah menjadi peserta
    $cek = DB::table('peserta_kelas')
        ->where('kelas_id', $id)
        ->where('user_id', Auth::id())
        ->exists();

if (!$cek) {

    DB::table('peserta_kelas')->insert([
        'kelas_id'   => $id,
        'user_id'    => Auth::id(),
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    return redirect('/ruang-kelas/'.$id)
        ->with(
            'success_gabung',
            'Selamat! Anda berhasil bergabung ke kelas "'.$kelas->nama_kelas.'".'
        );
}

return redirect('/ruang-kelas/'.$id);
});
    });

    // Pastikan nama route ini terdaftar persis seperti ini
    Route::post('/admin/kelas/simpan', [AdminController::class, 'simpanKelas'])->name('admin.simpanKelas');

    Route::middleware(['auth'])->get('/ambil-kelas-tutor', function () {
    
        return DB::table('kelas')
            ->where('tutor_id', Auth::id())
            ->orderByDesc('id')
            ->get();
    
    });

// 2. Jalur POST Khusus: Mengurus simpan kelas baru dari modal tutor
Route::post('/tutor/proses-tambah-kelas', function (Request $request) {
    $namaKelas = $request->input('nama_kelas');
    $deskripsiKelas = $request->input('deskripsi_kelas');
    $userId = Auth::id() ?: 1; 
    $waktu = now();

    DB::insert("INSERT INTO kelas (user_id, nama_kelas, deskripsi, created_at, updated_at) VALUES (?, ?, ?, ?, ?)", [
        $userId, $namaKelas, $deskripsiKelas, $waktu, $waktu
    ]);

    return redirect()->back(); // Otomatis refresh halaman setelah simpan
})->name('tutor.prosesSimpanKelas');


Route::get('/ruang-kelas/{id}', function ($id) {

   $kelas = DB::table('kelas')
    ->leftJoin('users','kelas.tutor_id','=','users.id')
    ->select(
        'kelas.*',
        'users.name as nama_tutor'
    )
    ->where('kelas.id',$id)
    ->first();

    $jumlahPeserta = DB::table('peserta_kelas')
        ->where('kelas_id', $id)
        ->count();
        

    $jumlahMateri = DB::table('materi_kelas')
        ->where('kelas_id', $id)
        ->where('tipe', 'materi')
        ->count();

    $jumlahTugas = DB::table('materi_kelas')
        ->where('kelas_id', $id)
        ->where('tipe', 'tugas')
        ->count();



    if (!$kelas) {
        return back();
    }

    // Jika Tutor
    if (Auth::user()->role == 'tutor') {

        if ($kelas->tutor_id != Auth::id()) {
            abort(403);
        }

    }

    $materi = DB::table('materi_kelas')
        ->where('kelas_id', $id)
        ->get();

    $peserta = DB::table('peserta_kelas')
        ->join('users', 'peserta_kelas.user_id', '=', 'users.id')
        ->select(
            'users.id',
            'users.name',
            'users.email'
        )
        ->where('peserta_kelas.kelas_id', $id)
        ->orderBy('users.name')
        ->get();

    return view('admin.detail_kelas', compact(
    'kelas',
    'materi',
    'peserta',
    'jumlahPeserta',
    'jumlahMateri',
    'jumlahTugas'
));
})->name('tutor.detailKelas');



// Jalur POST: Mengupload materi/tugas baru (Aksi dari modal tutor)
Route::post('/ruang-kelas/{id}/upload', function (Request $request, $id) {

    $judul      = $request->judul;
    $deskripsi  = $request->deskripsi;
    $tipe       = $request->tipe;
    $deadline   = $request->deadline;

    $file_path = null;
    $file_soal = null;

    // Jika ada file yang diupload
    if ($request->hasFile('file_materi')) {

        $file = $request->file('file_materi');

        $namaFile = time().'_'.$file->getClientOriginalName();

        $file->move(public_path('uploads/materi'), $namaFile);

        if ($tipe == 'materi') {
            $file_path = 'uploads/materi/'.$namaFile;
        } else {
            $file_soal = 'uploads/materi/'.$namaFile;
        }

    }

    DB::table('materi_kelas')->insert([

        'kelas_id'   => $id,
        'judul'      => $judul,
        'deskripsi'  => $deskripsi,
        'tipe'       => $tipe,
        'file_path'  => $file_path,
        'file_soal'  => $file_soal,
        'deadline'   => $deadline,
        'created_at' => now(),
        'updated_at' => now(),

    ]);

    return redirect()->back()->with('success','Materi berhasil diupload.');

});

Route::post('/tugas/{id}/upload-jawaban', function (Request $request, $id) {

    $fileJawaban = null;

    if ($request->hasFile('file_jawaban')) {

        $file = $request->file('file_jawaban');

        $namaFile = time().'_'.$file->getClientOriginalName();

        $file->move(public_path('uploads/jawaban'), $namaFile);

        $fileJawaban = 'uploads/jawaban/'.$namaFile;

    }

    DB::table('pengumpulan_tugas')->insert([

        'materi_id'     => $id,
        'kelas_id'      => $request->kelas_id,
        'user_id'       => Auth::id(),
        'file_jawaban'  => $fileJawaban,
        'keterangan'    => $request->keterangan,
        'created_at'    => now(),
        'updated_at'    => now(),

    ]);

    return back()->with('success','Jawaban berhasil dikumpulkan.');

});

Route::delete('/admin/kelas/{id}/hapus', function ($id) {

    if (Auth::user()->role != 'admin') {
        abort(403);
    }

    // hapus peserta kelas
    DB::table('peserta_kelas')
        ->where('kelas_id', $id)
        ->delete();

    // hapus materi
    DB::table('materi_kelas')
        ->where('kelas_id', $id)
        ->delete();

    // hapus kelas
    DB::table('kelas')
        ->where('id', $id)
        ->delete();

    return back()->with('success_kelas', 'Kelas berhasil dihapus.');

});

Route::post('/tutor/{id}/update', function ($id) {

    DB::table('users')
        ->where('id', $id)
        ->update([

            'name' => request('name'),
            'email' => request('email'),
            'bidang_keahlian' => request('bidang_keahlian'),
            'no_whatsapp' => request('no_whatsapp'),

        ]);

return back()->with('success_tutor', 'Profil tutor berhasil diperbarui.');

});
Route::delete('/materi/{id}/hapus', function ($id) {

    $materi = DB::table('materi_kelas')->where('id', $id)->first();

    if ($materi) {

        // Hapus file materi
        if (!empty($materi->file_path) && file_exists(public_path($materi->file_path))) {
            unlink(public_path($materi->file_path));
        }

        // Hapus file soal
        if (!empty($materi->file_soal) && file_exists(public_path($materi->file_soal))) {
            unlink(public_path($materi->file_soal));
        }

        // Jika ini tugas, hapus data pengumpulan siswa
        if ($materi->tipe == 'tugas') {
            DB::table('pengumpulan_tugas')
                ->where('materi_id', $id)
                ->delete();
        }

        // Hapus materi/tugas
        DB::table('materi_kelas')
            ->where('id', $id)
            ->delete();
    }

    return back()->with('success', 'Materi berhasil dihapus.');
});
