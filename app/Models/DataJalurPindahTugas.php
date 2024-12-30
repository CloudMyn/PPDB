<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataJalurPindahTugas extends Model
{
    /** @use HasFactory<\Database\Factories\DataJalurPindahTugasFactory> */
    use HasFactory;

    protected $fillable = [
        'formulir_id',
        'file_surat_mutasi_kerja_ortu',
        'file_kk',
        'file_surat_keterangan_domisili',
        'file_akta_kelahiran',
        'file_ijaza',
        'koordinat_bujur',
        'koordinat_lintang',
        'jarak',
    ];

    public function formulir()
    {
        return $this->belongsTo(Formulir::class);
    }
}
