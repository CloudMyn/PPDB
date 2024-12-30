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
        Schema::create('formulirs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('calon_siswa_id')->unique()->constrained('calon_siswas')->onDelete('cascade');
            $table->string('nomor_formulir')->unique();
            $table->string('foto');
            $table->string('nama_lengkap');
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->enum('jenis_kelamin', ['male', 'female']);
            $table->string('agama');
            $table->string('nomor_telepon');
            $table->string('alamat');
            $table->string('anak_ke');
            $table->string('nama_ayah');
            $table->string('pekerjaan_ayah');
            $table->string('nomor_telepon_ayah');
            $table->string('nama_ibu');
            $table->string('pekerjaan_ibu');
            $table->string('nomor_telepon_ibu');
            $table->string('alamat_ortu');
            $table->enum('jalur_pendaftaran', ['afirmasi', 'prestasi', 'pindah_tugas', 'zonasi']);
            $table->enum('status_pendaftaran', ['belum_verifikasi', 'berhasil_verifikasi', 'gagal_verifikasi'])
                ->default('belum_verifikasi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('formulirs');
    }
};
