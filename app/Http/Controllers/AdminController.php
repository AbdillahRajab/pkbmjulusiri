<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\SiswaImport;
use App\Models\Siswa;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index()
    {


$data_user = User::orderBy('id', 'desc')->get();



$data_tutor = User::where('role', 'tutor')
    ->orderBy('id', 'desc')
    ->get();

$data_admin = User::where('role', 'admin')
    ->orderBy('id', 'desc')
    ->get();
    
$data_siswa = Siswa::orderBy('id', 'desc')->get();

        // 3. DATA FORMULIR PENDAFTARAN
        try {
            $data_pendaftar = DB::table('pendaftarans')->orderBy('id', 'desc')->get();
        } catch (\Exception $e) {
            $data_pendaftar = collect([]);
        }
        

// Data kelas berdasarkan role
if (Auth::user()->role == 'admin') {

    // Admin melihat semua kelas beserta nama tutor
    $data_kelas = DB::table('kelas')
        ->join('users', 'kelas.tutor_id', '=', 'users.id')
        ->select(
            'kelas.*',
            'users.name as nama_tutor'
        )
        ->orderBy('kelas.id', 'desc')
        ->get();
           $data_kelas_saya = collect();

} elseif (Auth::user()->role == 'tutor') {

    // Tutor hanya melihat kelas miliknya
    $data_kelas = DB::table('kelas')
        ->join('users', 'kelas.tutor_id', '=', 'users.id')
        ->select(
            'kelas.*',
            'users.name as nama_tutor'
        )
        ->where('kelas.tutor_id', Auth::id())
        ->orderBy('kelas.id', 'desc')
        ->get();
   $data_kelas_saya = collect();

} else {

    // Siswa melihat semua kelas yang telah dibuat admin
$data_kelas = DB::table('kelas')
    ->leftJoin('users', 'kelas.tutor_id', '=', 'users.id')
    ->leftJoin('peserta_kelas', function ($join) {
        $join->on('kelas.id', '=', 'peserta_kelas.kelas_id')
             ->where('peserta_kelas.user_id', Auth::id());
    })
    ->select(
        'kelas.*',
        'users.name as nama_tutor',
        DB::raw('(SELECT COUNT(*) FROM peserta_kelas WHERE peserta_kelas.kelas_id = kelas.id) as jumlah_peserta')
    )
    ->whereNull('peserta_kelas.id') // hanya kelas yang BELUM diikuti
    ->orderBy('kelas.id', 'desc')
    ->get();

    // Kelas saya
    $data_kelas_saya = DB::table('peserta_kelas')
    ->join('kelas', 'peserta_kelas.kelas_id', '=', 'kelas.id')
    ->leftJoin('users', 'kelas.tutor_id', '=', 'users.id')
    ->select(
        'kelas.*',
        'users.name as nama_tutor',
        DB::raw('(SELECT COUNT(*) FROM peserta_kelas WHERE peserta_kelas.kelas_id = kelas.id) as jumlah_peserta')
    )
    ->where('peserta_kelas.user_id', Auth::id())
    ->get();
}
$data_mapel = collect();
$data_berita = DB::table('berita')
    ->leftJoin('users', 'berita.created_by', '=', 'users.id')
    ->select(
        'berita.*',
        'users.name as nama_admin'
    )
    ->orderBy('berita.id', 'desc')
    ->get();
    $berita = DB::table('berita')
    ->orderBy('created_at', 'desc')
    ->get();

        // 4. HITUNG STATISTIK REAL-TIME
        $total_siswa     = $data_siswa->count();
        $total_tutor     = $data_tutor->count();
        $total_user = $data_user->count();
        $total_pendaftar = $data_pendaftar->count();
        $total_kelas     = $data_kelas->count();
        $total_berita    = $data_berita->count();

        return view('admin.elearning', compact(
              'data_kelas','data_kelas_saya','data_mapel','data_tutor','data_siswa','data_admin','data_pendaftar','total_siswa','total_tutor',
              'total_kelas','total_pendaftar','total_user','total_berita','data_user','data_berita','berita'
        ));
    }

   public function storePendaftaran(Request $request)
{
    // 1. Longgarkan validasi sementara untuk testing
    $request->validate([
        'nama_lengkap' => 'nullable', // ubah dulu ke nullable agar tidak mencegat data
        'nik'          => 'nullable',
    ]);

    try {
        // 2. Proses Insert ke DB
        DB::table('pendaftarans')->insert([
            // Sesuaikan kolom kiri dengan nama kolom asli di phpMyAdmin Anda!
            'nama_lengkap'       => $request->input('nama_lengkap') ?? $request->input('name'), 
            'nik'                => $request->input('nik'),
            'status_verifikasi'  => 'pending', // Status awal agar terbaca di Dashboard Admin
            'created_at'         => now(),
            'updated_at'         => now()
        ]);

        // Mengembalikan dengan session 'sukses_data' yang kita tangkap di Langkah 1
        return redirect('/')->with('sukses_data', 'Pendaftaran Anda berhasil dikirim! Silakan tunggu verifikasi dari Admin.');

    } catch (\Exception $e) {
        // Jika ada eror database (misal nama kolom salah), dia akan memunculkan pesan eror aslinya
        return redirect('/')->with('error_data', 'Gagal menyimpan ke database: ' . $e->getMessage());
    }
}

public function simpanKelas(Request $request)
{
    $request->validate([
        'nama_kelas' => 'required|string|max:255',
        'tutor_id'   => 'required|integer',
        'deskripsi'  => 'nullable|string',
    ]);

    DB::table('kelas')->insert([
        'nama_kelas' => $request->nama_kelas,
        'tutor_id'   => $request->tutor_id,
        'deskripsi'  => $request->deskripsi,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

return back()->with('success_kelas', 'Kelas berhasil dibuat.');
}
public function simpanBerita(Request $request)
{
    DB::table('berita')->insert([

        'judul'      => $request->judul,
        'isi'        => $request->isi,
        'created_by' => Auth::id(),
        'created_at' => now(),
        'updated_at' => now(),

    ]);

    return back()->with('success_berita', 'Berita berhasil dipublikasikan.');
}
public function hapusBerita($id)
{
    DB::table('berita')
        ->where('id', $id)
        ->delete();

    return back()->with(
        'success_berita',
        'Berita berhasil dihapus.'
    );
}


public function updatePasswordKelas(Request $request, $id)
{
    $request->validate([
        'password_kelas' => 'nullable|string|max:50'
    ]);

    DB::table('kelas')
        ->where('id', $id)
        ->update([
            'password_kelas' => $request->password_kelas
        ]);

    return back()->with('success', 'Password kelas berhasil diperbarui.');
}

public function cetakPendaftaran($id)
{
    $pendaftar = DB::table('pendaftarans')
        ->where('id',$id)
        ->first();

    $pdf = Pdf::loadView(
        'admin.cetak_pendaftaran',
        compact('pendaftar')
    );

    $pdf->setPaper('A4','portrait');

    return $pdf->stream(
        'Formulir-'.$pendaftar->nama.'.pdf'
    );
}
public function formImportSiswa()
{
    return view('admin.import_siswa');
}
public function importSiswa(Request $request)
{
    $request->validate([
        'file' => 'required|mimes:xlsx,xls'
    ]);

    Excel::import(new SiswaImport, $request->file('file'));

    return back()->with('success', 'Import berhasil.');
}
public function aktifkanAkun($id)
{
    $siswa = Siswa::findOrFail($id);

    // Jika akun sudah pernah dibuat
    if ($siswa->user_id) {
        return back()->with('error', 'Akun siswa sudah aktif.');
    }

    // Email sementara berdasarkan NIS
    $email = $siswa->nis . '@pkbmjulusiri.id';

    // Cek jika email sudah dipakai
    if (User::where('email', $email)->exists()) {
        return back()->with('error', 'Email sudah digunakan.');
    }

    // Buat akun user
    $user = User::create([
        'name'     => $siswa->nama,
        'email'    => $email,
        'password' => Hash::make($siswa->nis),
        'role'     => 'siswa',
    ]);

    // Hubungkan ke tabel siswas
    $siswa->user_id = $user->id;
    $siswa->status_akun = 1;
    $siswa->save();

    return redirect()
    ->route('elearning.index')
    ->with('success', 'Akun siswa berhasil diaktifkan.');
}
}
