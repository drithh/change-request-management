<?php

namespace Database\Seeders;

use App\Models\ScopeOfChange;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ScopeOfChangeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $scopes = ['Quality', 'Safety', 'Environment'];

        foreach ($scopes as $scope) {
            ScopeOfChange::create([
                'value' => $scope
            ]);
        }
    }
}
