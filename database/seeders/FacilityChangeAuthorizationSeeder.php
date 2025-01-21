<?php

namespace Database\Seeders;

use App\Models\FacilityChangeAuthorization;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FacilityChangeAuthorizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Perubahan fasilitas dapat langsung diimplementasikan setelah penyampaian notifikasi kepada BPOM.
        // Perubahan fasilitas tidak dapat langsung diimplementasikan karena perlu persetujuan notifikasi dari BPOM.
        // Perubahan fasilitas tidak dapat langsung diimplementasikan karena perlu inspeksi dari BPOM.
        // Perubahan tidak terkait fasilitas

        $facilityChangeAuthorizations = ['Perubahan fasilitas dapat langsung diimplementasikan setelah penyampaian notifikasi kepada BPOM.', 'Perubahan fasilitas tidak dapat langsung diimplementasikan karena perlu persetujuan notifikasi dari BPOM.', 'Perubahan fasilitas tidak dapat langsung diimplementasikan karena perlu inspeksi dari BPOM.', 'Perubahan tidak terkait fasilitas'];

        foreach ($facilityChangeAuthorizations as $facilityChangeAuthorization) {
            FacilityChangeAuthorization::create([
                'value' => $facilityChangeAuthorization
            ]);
        }
    }
}
