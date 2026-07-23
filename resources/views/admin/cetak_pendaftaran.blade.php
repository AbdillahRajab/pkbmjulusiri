<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Formulir Pendaftaran</title>

    <style>
        @page{
            margin:25px;
        }

        body{
            font-family:"Times New Roman", Times, serif;
            color:#000;
            font-size:13px;
            line-height:1.4;
        }

        table{
            width:100%;
            border-collapse:collapse;
        }

        .kop td{
            vertical-align:top;
        }

        .logo{
            width:95px;
        }

        .nama-instansi{
            text-align:center;
        }

        .nama-instansi h2{
            margin:0;
            font-size:23px;
            font-weight:bold;
        }

        .nama-instansi h3{
            margin:2px 0;
            font-size:18px;
            font-weight:bold;
        }

        .nama-instansi p{
            margin:2px 0;
            font-size:13px;
        }

        .garis1{
            border-top:3px solid #000;
            margin-top:10px;
        }

        .garis2{
            border-top:1px solid #000;
            margin-top:2px;
            margin-bottom:25px;
        }

        .nomor{
            text-align:right;
            font-weight:bold;
            margin-bottom:20px;
        }

        .judul{
            text-align:center;
            margin-bottom:30px;
        }

        .judul h2{
            margin:0;
            font-size:20px;
        }

        .judul p{
            margin-top:5px;
            font-size:14px;
        }
        .section-title{
    background:#efefef;
    border-left:5px solid #000;
    padding:8px 12px;
    font-weight:bold;
    margin:25px 0 10px;
    font-size:15px;
}

.form-table{
    width:100%;
    border-collapse:collapse;
    margin-bottom:20px;
}

.form-table td{
    padding:6px 4px;
    vertical-align:top;
}

.label{
    width:220px;
    font-weight:bold;
}

.titik{
    width:15px;
    text-align:center;
}

.value{
    border-bottom:1px dotted #555;
}
.berkas-table{
    width:100%;
    border-collapse:collapse;
    margin-top:10px;
    margin-bottom:25px;
}

.berkas-table th,
.berkas-table td{
    border:1px solid #000;
    padding:8px;
    font-size:13px;
}

.berkas-table th{
    background:#efefef;
    text-align:center;
}

.center{
    text-align:center;
}
.ttd{
    width:100%;
    margin-top:60px;
}

.ttd td{
    width:50%;
    vertical-align:top;
}

.ttd-kanan{
    text-align:center;
}

.garis-ttd{
    margin-top:80px;
    font-weight:bold;
    text-decoration:underline;
}

.keterangan{
    font-size:13px;
    margin-top:3px;
}

.footer{
    margin-top:40px;
    font-size:12px;
    text-align:center;
    color:#555;
    border-top:1px solid #999;
    padding-top:10px;
}
    </style>

</head>

<body>

<table class="kop">

    <tr>

        <td width="110" align="center">

            <img src="{{ public_path('images/logo3.png') }}" width="90">

        </td>

        <td class="nama-instansi">

            <h2>PUSAT KEGIATAN BELAJAR MASYARAKAT (PKBM)</h2>

            <h2>"JULU SIRI"</h2>

            <h3>PANGKAJENE KEPULAUAN</h3>

            <p>NPSN : 9984290</p>

            <p>Email : pkbm.julusiri@gmail.com</p>

            <p>
                Jl. Andi Mauraga No.21 RT.003 RW.003 Jagong,
                Kecamatan Pangkajene,
                Kabupaten Pangkep,
                Sulawesi Selatan
            </p>

        </td>

    </tr>

</table>

<div class="garis1"></div>
<div class="garis2"></div>

<div class="nomor">

    Nomor Formulir :
    <strong>
        FP-{{ str_pad($pendaftar->id,6,'0',STR_PAD_LEFT) }}
    </strong>

</div>

<div class="judul">

    <h2>FORMULIR PENDAFTARAN PESERTA DIDIK BARU</h2>

    <p>
        PKBM JULU SIRI PANGKAJENE KEPULAUAN
    </p>

</div>
<div class="section-title">
    A. DATA CALON PESERTA DIDIK
</div>

<table class="form-table">

<tr>
    <td class="label">Nomor Formulir</td>
    <td class="titik">:</td>
    <td class="value">
        FP-{{ str_pad($pendaftar->id,6,'0',STR_PAD_LEFT) }}
    </td>
</tr>

<tr>
    <td class="label">Nama Lengkap</td>
    <td class="titik">:</td>
    <td class="value">{{ $pendaftar->nama }}</td>
</tr>

<tr>
    <td class="label">Tempat Lahir</td>
    <td class="titik">:</td>
    <td class="value">{{ $pendaftar->tempat_lahir }}</td>
</tr>

<tr>
    <td class="label">Tanggal Lahir</td>
    <td class="titik">:</td>
    <td class="value">{{ $pendaftar->tanggal_lahir }}</td>
</tr>

<tr>
    <td class="label">Jenis Kelamin</td>
    <td class="titik">:</td>
    <td class="value">{{ $pendaftar->jenis_kelamin }}</td>
</tr>

<tr>
    <td class="label">Alamat</td>
    <td class="titik">:</td>
    <td class="value">{{ $pendaftar->alamat }}</td>
</tr>

<tr>
    <td class="label">No. HP / WhatsApp</td>
    <td class="titik">:</td>
    <td class="value">{{ $pendaftar->nohp }}</td>
</tr>

<tr>
    <td class="label">Program Paket</td>
    <td class="titik">:</td>
    <td class="value">{{ $pendaftar->paket }}</td>
</tr>

</table>
<div class="section-title">
    B. KELENGKAPAN BERKAS PERSYARATAN
</div>

<table class="berkas-table">

<tr>
    <th width="60%">Jenis Berkas</th>
    <th width="20%">Status</th>
</tr>

<tr>
    <td>Fotokopi KTP</td>
    <td class="center">
        {{ $pendaftar->file_ktp ? 'Ada' : '-' }}
    </td>
</tr>

<tr>
    <td>Fotokopi Kartu Keluarga (KK)</td>
    <td class="center">
        {{ $pendaftar->file_kk ? 'Ada' : '-' }}
    </td>
</tr>

<tr>
    <td>Ijazah Terakhir</td>
    <td class="center">
        {{ $pendaftar->file_ijazah ? 'Ada' : '-' }}
    </td>
</tr>

<tr>
    <td>Akta Kelahiran</td>
    <td class="center">
        {{ $pendaftar->file_akta ? 'Ada' : '-' }}
    </td>
</tr>

</table>
<div class="section-title">
    C. HASIL VERIFIKASI ADMIN
</div>

<table class="form-table">

<tr>
    <td class="label">Status Pendaftaran</td>
    <td class="titik">:</td>
    <td class="value">

        @if($pendaftar->status=="Diterima")
            <strong style="color:green;">DITERIMA</strong>

        @elseif($pendaftar->status=="Ditolak")

            <strong style="color:red;">DITOLAK</strong>

        @else

            <strong>MENUNGGU VERIFIKASI</strong>

        @endif

    </td>
</tr>

</table>
<table class="ttd">

<tr>

<td>

</td>

<td class="ttd-kanan">

Pangkajene,
{{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}

<br><br>

Administrator PKBM

<div class="garis-ttd">

........................................

</div>

<div class="keterangan">

(Admin PKBM Julu Siri)

</div>

</td>

</tr>

</table>
<div class="footer">

Dokumen ini dicetak otomatis melalui Sistem Informasi Pendaftaran Peserta Didik Baru
PKBM Julu Siri Pangkajene Kepulauan.

</div>

</body>

</html>