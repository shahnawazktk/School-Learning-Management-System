<?php

namespace Database\Seeders;

use App\Models\User;


use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@school.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Teacher User',
            'email' => 'teacher@school.com',
            'password' => bcrypt('password'),
            'role' => 'teacher',
        ]);

        User::create([
            'name' => 'Student User',
            'email' => 'student@school.com',
            'password' => bcrypt('password'),
            'role' => 'student',
        ]);

        User::create([
            'name' => 'Parent User',
            'email' => 'parent@school.com',
            'password' => bcrypt('password'),
            'role' => 'parent',
        ]);
    }
}
