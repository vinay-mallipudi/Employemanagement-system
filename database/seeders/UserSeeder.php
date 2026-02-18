<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       User:: create([
        'name' => 'Admin',
        'email' => 'admin@gmail.com',
        'password' => Hash::make('12345678'),
        'contact_no' => '9848132081',
        'role' => 'admin',
        'status' => 1,
        'email_verified_at' => now(),

       ]);
       $employeeUser = User:: create([
        'name' => 'Employee',
        'email' => 'employee@gmail.com',
        'password' => Hash::make('12345678'),
        'contact_no' => '9848132084',
        'role' => 'employee',
        'status' => 1,
        'email_verified_at' => now(),

       ]);

       // Create Employee Record
       \App\Models\Employees::create([
           'user_id' => $employeeUser->id,
           'first_name' => 'Demo',
           'last_name' => 'Employee',
           'contact_no' => '9848132084',
           'address' => '123 Demo St',
           'birthday' => '1990-01-01',
           'joining_date' => now(),
           'salary' => 50000,
           'experience_years' => 2,
           'status' => 'active',
           // Assuming department_id 1 exists from DepartmentSeeder, fallback to null if necessary but better to be safe
       ]);
    }
}
