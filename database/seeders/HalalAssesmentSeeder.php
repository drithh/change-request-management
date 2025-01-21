<?php

namespace Database\Seeders;

use App\Models\HalalAssesment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HalalAssesmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ya, Perubahan memerlukan persetujuan BPJPH terlebih dahulu
        // Ya, Namun perubahan tidak memerlukan persetujuan BPJPH terlebih dahulu
        // Tidak



        $halalAssesments = ['Ya, Perubahan memerlukan persetujuan BPJPH terlebih dahulu', 'Ya, Namun perubahan tidak memerlukan persetujuan BPJPH terlebih dahulu', 'Tidak'];

        foreach ($halalAssesments as $halalAssesment) {
            HalalAssesment::create([
                'value' => $halalAssesment
            ]);
        }
    }
}
