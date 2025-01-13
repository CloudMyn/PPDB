<?php

namespace Database\Factories;

use App\Models\CalonSiswa;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Formulir>
 */
class FormulirFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'foto'  => $this->faker->imageUrl(),
            'calon_siswa_id' => CalonSiswa::factory()->create()->id,
            'nomor_formulir' => $this->faker->unique()->regexify('[A-Z]{3}[0-9]{3}'),
            'nama_lengkap' => $this->faker->name(),
            'tempat_lahir' => $this->faker->city(),
            'tanggal_lahir' => $this->faker->date(),
            'jenis_kelamin' => $this->faker->randomElement(['male', 'female']),
            'agama' => $this->faker->randomElement(['islam', 'kristen', 'katolik', 'hindu', 'buddha']),
            'nomor_telepon' => $this->faker->phoneNumber(),
            'alamat' => $this->faker->address(),
            'anak_ke' => $this->faker->numberBetween(1, 10),
            'nama_ayah' => $this->faker->name(),
            'pekerjaan_ayah' => $this->faker->jobTitle(),
            'nomor_telepon_ayah' => $this->faker->phoneNumber(),
            'nama_ibu' => $this->faker->name(),
            'pekerjaan_ibu' => $this->faker->jobTitle(),
            'nomor_telepon_ibu' => $this->faker->phoneNumber(),
            'alamat_ortu' => $this->faker->address(),
            'status_pendaftaran' => $this->faker->randomElement(['belum_verifikasi', 'berhasil_verifikasi', 'gagal_verifikasi']),
            'jalur_pendaftaran' => $this->faker->randomElement(['afirmasi', 'prestasi', 'pindah_tugas', 'zonasi']),
        ];
    }
}
