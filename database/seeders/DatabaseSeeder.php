<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'is_admin' => true,
            'is_verified' => true,
        ]);

        $this->call([
            DepartmentSeeder::class,
            FacilityChangeAuthorizationSeeder::class,
            HalalAssesmentSeeder::class,
            RegulatoryAssesmentSeeder::class,
            ScopeOfChangeSeeder::class,
            StimuliOfChangeSeeder::class,
        ]);
    }
}
