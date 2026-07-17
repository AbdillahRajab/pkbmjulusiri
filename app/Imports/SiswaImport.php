<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Models\Siswa;


class SiswaImport implements ToCollection
{
   public function collection(Collection $rows)
{
    $data = [];

    foreach ($rows as $index => $row) {

        // Lewati header dan informasi di atas data siswa
        if ($index < 6) {
            continue;
        }

        // Lewati jika nama kosong
        if (empty(trim($row[1] ?? ''))) {
            continue;
        }

        $tglLahir = null;

        if (!empty($row[5])) {
            try {
                $tglLahir = date('Y-m-d', strtotime($row[5]));
            } catch (\Exception $e) {
                $tglLahir = null;
            }
        }

        $data[] = [
            'nama'             => trim($row[1] ?? ''),
            'jenis_kelamin'    => trim($row[2] ?? ''),
            'nis'              => trim($row[3] ?? ''),
            'tempat_lahir'     => trim($row[4] ?? ''),
            'tgl_lahir'        => $tglLahir,
            'nik'              => trim($row[6] ?? ''),
            'agama'            => trim($row[7] ?? ''),
            'alamat'           => trim($row[8] ?? ''),
            'kelurahan_desa'   => trim($row[9] ?? ''),
            'kecamatan'        => trim($row[10] ?? ''),
            'nama_ayah'        => trim($row[11] ?? ''),
            'nik_ayah'         => trim($row[12] ?? ''),
            'nama_ibu'         => trim($row[13] ?? ''),
            'nik_ibu'          => trim($row[14] ?? ''),
            'kelas'            => trim($row[15] ?? ''),
            'created_at'       => now(),
            'updated_at'       => now(),
        ];
    }

    foreach (array_chunk($data, 100) as $chunk) {
        Siswa::insert($chunk);
    }
}
}