<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Formulir extends Model
{
    /** @use HasFactory<\Database\Factories\FormulirFactory> */
    use HasFactory;
    protected $fillable = [
        'calon_siswa_id',
        'nomor_formulir',
        'foto',
        'nama_lengkap',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'agama',
        'nomor_telepon',
        'alamat',
        'anak_ke',
        'nama_ayah',
        'pekerjaan_ayah',
        'nomor_telepon_ayah',
        'nama_ibu',
        'pekerjaan_ibu',
        'nomor_telepon_ibu',
        'alamat_ortu',
        'status_pendaftaran',
        'jalur_pendaftaran',
    ];

    public function calonSiswa()
    {
        return $this->belongsTo(CalonSiswa::class);
    }

    public static function daftar($data)
    {
        $data['calon_siswa_id']     =   get_auth_user()->calonSiswa->id;
        $data['nomor_formulir']     =   rand(1000000, 9999999);
        $data['status_pendaftaran'] =   'belum_verifikasi';
        $data['nomor_telepon']      =   get_auth_user()->calonSiswa->telepon;

        $formulir = self::create($data);

        return $formulir;
    }

    public function jalurAfirmasi()
    {
        return $this->hasOne(DataJalurAfirmasi::class);
    }

    public function jalurZonasi()
    {
        return $this->hasOne(DataJalurZonasi::class);
    }

    public function jalurPrestasi()
    {
        return $this->hasOne(DataJalurPrestasi::class);
    }

    public function jalurPrestasiSiswa()
    {
        return $this->hasOne(DataJalurPrestasi::class);
    }
}
