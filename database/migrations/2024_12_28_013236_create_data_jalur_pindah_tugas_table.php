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
        Schema::create('data_jalur_pindah_tugas', function (Blueprint $table) {
            $table->id();
            $table->foreignId(column: 'formulir_id')->constrained()->cascadeOnDelete();
            $table->string('file_surat_mutasi_kerja_ortu')
                ->nullable()
                ->comment('Dikeluarkan oleh instansi/lembaga tempat bekerja.');
            $table->string('file_kk')
                ->nullable()
                ->comment('Bukti tempat tinggal calon siswa.');
            $table->string('file_surat_keterangan_domisili')
                ->nullable()
                ->comment('Jika alamat di KK belum diperbarui.');
            $table->string('file_akta_kelahiran')
                ->nullable()
                ->comment('Untuk validasi data calon siswa.');
            $table->string('file_ijaza')
                ->nullable()
                ->comment('Untuk membuktikan kelulusan pendidikan sebelumnya.');
            $table->string('koordinat_bujur');
            $table->string('koordinat_lintang');
            $table->integer('jarak');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_jalur_pindah_tugas');
    }
};