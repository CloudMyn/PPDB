<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataJalurZonasi extends Model
{
    /** @use HasFactory<\Database\Factories\DataJalurZonasiFactory> */
    use HasFactory;

    protected $fillable = [
        'formulir_id',
        'file_kk',
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
