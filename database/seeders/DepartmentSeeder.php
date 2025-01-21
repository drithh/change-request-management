<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Produksi
        // Quality Assurance
        // Quality Control
        // PPIC & Warehouse
        // HR & GA
        // Finance & Accounting
        // Engineering
        // Marketing
        // Management Information System
        // Sales
        // Produksi
        // Product Development

        $departments = ['Produksi', 'Quality Assurance', 'Quality Control', 'PPIC & Warehouse', 'HR & GA', 'Finance & Accounting', 'Engineering', 'Marketing', 'Management Information System', 'Sales', 'Product Development'];

        foreach ($departments as $department) {
            Department::create([
                'name' => $department
            ]);
        }
    }
}
