@section('content')

<div class="container-fluid mt-4">

    <div class="card shadow border-0">

        <div class="card-header bg-success text-white">

            <h4 class="mb-0">
                <i class="bi bi-file-earmark-excel"></i>
                Import Data Warga Belajar
            </h4>

        </div>

        <div class="card-body">

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div class="alert alert-info">

                <b>Petunjuk Import :</b>

                <ul class="mb-0 mt-2">

                    <li>Format file harus Excel (.xlsx atau .xls)</li>

                    <li>Kolom harus sesuai template.</li>

                    <li>Username otomatis menggunakan NIS.</li>

                    <li>Password otomatis menggunakan tanggal lahir (ddmmyyyy).</li>

                </ul>

            </div>

            <form method="POST"
                  action="{{ route('admin.siswa.import.proses') }}"
                  enctype="multipart/form-data">

                @csrf

                <div class="mb-3">

                    <label class="form-label">

                        Pilih File Excel

                    </label>

                    <input
                        type="file"
                        name="file"
                        class="form-control"
                        accept=".xlsx,.xls"
                        required>

                </div>

                <button class="btn btn-success">

                    <i class="bi bi-upload"></i>

                    Import Data

                </button>

            </form>

        </div>

    </div>

</div>

