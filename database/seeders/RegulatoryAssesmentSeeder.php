<?php

namespace Database\Seeders;

use App\Models\RegulatoryAssesment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RegulatoryAssesmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Perubahan dapat langsung dilaksanakan tanpa menunggu Izin dari Badan POM karena pemberitahuan akan disampaikan dengan perubahan dokumen bersangkutan (Notifikasi) oleh bagian Registrasi
        // Perubahan dapat langsung dilaksanakan tanpa menunggu Izin dari Badan POM karena tidak diperlukan pemberitahuan perubahan.
        // Perubahan tidak dapat langsung dilaksanakan karena memerlukan izin BPOM terlebih dahulu
        // Perubahan tidak terkait Registrasi


        $regulatoryAssesments = ['Perubahan dapat langsung dilaksanakan tanpa menunggu Izin dari Badan POM karena pemberitahuan akan disampaikan dengan perubahan dokumen bersangkutan (Notifikasi) oleh bagian Registrasi', 'Perubahan dapat langsung dilaksanakan tanpa menunggu Izin dari Badan POM karena tidak diperlukan pemberitahuan perubahan.', 'Perubahan tidak dapat langsung dilaksanakan karena memerlukan izin BPOM terlebih dahulu', 'Perubahan tidak terkait Registrasi'];

        foreach ($regulatoryAssesments as $regulatoryAssesment) {
            RegulatoryAssesment::create([
                'value' => $regulatoryAssesment
            ]);
        }
    }
}
