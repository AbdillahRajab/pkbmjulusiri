<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
  public function up(): void
{
    Schema::create('siswas', function (Blueprint $table) {

        $table->id();

        // Relasi ke tabel users
        $table->foreignId('user_id')
              ->constrained('users')
              ->onDelete('cascade');

        // Biodata Siswa
        $table->string('nis')->unique();

        $table->string('nik')->nullable();

        $table->string('jenis_kelamin')->nullable();

        $table->string('tempat_lahir')->nullable();

        $table->date('tanggal_lahir')->nullable();

        $table->string('agama')->nullable();

        $table->text('alamat')->nullable();

        $table->string('kelurahan_desa')->nullable();

        $table->string('kecamatan')->nullable();

        $table->string('kelas')->nullable();

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('siswas');
    }
};
