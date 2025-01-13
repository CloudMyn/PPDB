<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pengumuman>
 */
class PengumumanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'calon_siswa_id' => \App\Models\CalonSiswa::inRandomOrder()->first()->id,
            'jalur_pendaftaran' => $this->faker->randomElement(['afirmasi', 'prestasi', 'pindah_tugas', 'zonasi']),
            'status' => $this->faker->randomElement(['LULUS', 'GAGAL']),
        ];
    }
}
