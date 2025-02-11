<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataJalurAfirmasi extends Model
{
    /** @use HasFactory<\Database\Factories\DataJalurAfirmasiFactory> */
    use HasFactory;

    protected $fillable = [
        'formulir_id',
        'file_kk',
        'file_akta_kelahiran',
        'file_ijaza',
        'file_kip',
        'file_sktm',
        'koordinat_bujur',
        'koordinat_lintang',
        'jarak',
    ];

    public function formulir()
    {
        return $this->belongsTo(Formulir::class);
    }
}
