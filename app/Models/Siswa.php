<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    protected $fillable = [
        'nama',
        'jenis_kelamin',
        'nis',
        'tempat_lahir',
        'tgl_lahir',
        'nik',
        'agama',
        'alamat',
        'kelurahan_desa',
        'kecamatan',
        'nama_ayah',
        'nik_ayah',
        'nama_ibu',
        'nik_ibu',
        'kelas',
        'user_id',
    ];
}