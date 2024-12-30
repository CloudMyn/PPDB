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
        Schema::create('data_jalur_afirmasis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('formulir_id')->constrained()->cascadeOnDelete();
            $table->string('file_kk')
                ->nullable()
                ->comment('Bukti tempat tinggal calon siswa.');
            $table->string('file_akta_kelahiran')
                ->nullable()
                ->comment('Untuk validasi data calon siswa.');
            $table->string('file_ijaza')
                ->nullable()
                ->comment('Untuk membuktikan kelulusan pendidikan sebelumnya.');
            $table->string('file_kip')
                ->nullable()
                ->comment('Sebagai bukti bahwa calon siswa berasal dari keluarga kurang mampu.');
            $table->string('file_sktm')
                ->nullable()
                ->comment('Surat resmi dari kelurahan atau kecamatan yang menyatakan status ekonomi keluarga.');
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
        Schema::dropIfExists('data_jalur_afirmasis');
    }
};
