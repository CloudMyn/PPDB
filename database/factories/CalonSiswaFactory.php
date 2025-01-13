<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CalonSiswa>
 */
class CalonSiswaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id'   =>  User::factory()->create()->id,
            'nama_lengkap' => $this->faker->name(),
            'nisn' => $this->faker->unique()->numerify('##########'),
            'tanggal_lahir' => rand(2000, 2005) . '-' . rand(1, 12) . '-' . rand(1, 28),
            'jenis_kelamin' => $this->faker->randomElement(['male', 'female']),
            'alamat' => $this->faker->address(),
            'telepon' => $this->faker->unique()->numerify('08##########'),
        ];
    }
}
