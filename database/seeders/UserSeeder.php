<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@school.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        $teacherUser = User::create([
            'name' => 'Teacher User',
            'email' => 'teacher@school.com',
            'password' => bcrypt('password'),
            'role' => 'teacher',
        ]);

        Teacher::create([
            'user_id' => $teacherUser->id,
            'teacher_id' => 'TCH2024001',
            'department' => 'Mathematics',
            'qualification' => 'M.Sc Mathematics',
            'experience' => 5,
            'joining_date' => now()->subYears(5),
            'date_of_birth' => now()->subYears(35),
            'gender' => 'male',
            'status' => 'active',
        ]);

        $studentUser = User::create([
            'name' => 'Student User',
            'email' => 'student@school.com',
            'password' => bcrypt('password'),
            'role' => 'student',
        ]);

        Student::create([
            'user_id' => $studentUser->id,
            'student_id' => 'STU2024001',
            'class' => '10',
            'section' => 'A',
            'roll_number' => 1,
            'academic_year' => '2024-2025',
            'enrollment_date' => now(),
            'date_of_birth' => now()->subYears(16),
            'gender' => 'male',
            'status' => 'active',
        ]);

        User::create([
            'name' => 'Parent User',
            'email' => 'parent@school.com',
            'password' => bcrypt('password'),
            'role' => 'parent',
        ]);
    }
}
