<?php

namespace Database\Seeders;

use App\Models\Departments;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
      Departments::insert([
        ['name' => 'HR', 'description' => 'Human Resources'],
        ['name' => 'Finance', 'description' => 'Finance Department'],
        ['name' => 'IT', 'description' => 'Information Technology'],
        ['name' => 'Marketing', 'description' => 'Marketing Team'],
    ]);
    }
}
