<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CalonSiswa extends Model
{
    /** @use HasFactory<\Database\Factories\CalonSiswaFactory> */
    use HasFactory;

    protected $table = 'calon_siswas';

    protected $fillable = [
        'nama_lengkap',
        'nisn',
        'tanggal_lahir',
        'jenis_kelamin',
        'alamat',
        'telepon',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function formulir()
    {
        return $this->hasOne(Formulir::class);
    }

    public function pengumuman()
    {
        return $this->hasOne(Pengumuman::class);
    }

    public static function daftar($data)
    {
        $model = new self($data);

        $model->user()->associate(get_auth_user());

        $model->save();
    }
}
