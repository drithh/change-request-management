<?php

namespace Database\Seeders;

use App\Models\StimuliOfChange;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StimuliOfChangeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $stimulis = ['Continual improvement / Inovasi', 'Transfer Teknologi', 'Corrective / Preventive', 'Alih daya / Perubahan kepemilikan produk', 'Aspek Pembuatan Produk', 'Penyesuaian regulasi / monografi', 'Perubahan bisnis proses', 'Relokasi fasilitas / pabrik', 'Keluaran kinerja proses', 'Pemantauan kualitas produk'];

        foreach ($stimulis as $stimuli) {
            StimuliOfChange::create([
                'value' => $stimuli
            ]);
        }
    }
}
