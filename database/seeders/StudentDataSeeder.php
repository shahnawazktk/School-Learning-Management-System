<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Assignment;
use App\Models\Submission;
use App\Models\Attendance;
use App\Models\GradeScore;
use App\Models\Resource;
use App\Models\Exam;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class StudentDataSeeder extends Seeder
{
    public function run(): void
    {
        $this->ensureSampleFiles();

        // Create subjects
        $subjects = [
            ['name' => 'Mathematics', 'code' => 'MATH101', 'description' => 'Advanced Mathematics', 'credits' => 4],
            ['name' => 'Physics', 'code' => 'PHY101', 'description' => 'General Physics', 'credits' => 4],
            ['name' => 'Chemistry', 'code' => 'CHEM101', 'description' => 'General Chemistry', 'credits' => 3],
            ['name' => 'English', 'code' => 'ENG101', 'description' => 'English Literature', 'credits' => 3],
            ['name' => 'Computer Science', 'code' => 'CS101', 'description' => 'Introduction to Programming', 'credits' => 4],
        ];

        foreach ($subjects as $subjectData) {
            Subject::firstOrCreate(['code' => $subjectData['code']], $subjectData);
        }

        // Create teacher user
        $teacher = User::firstOrCreate(
            ['email' => 'teacher@school.com'],
            [
                'name' => 'Teacher User',
                'password' => Hash::make('password'),
                'role' => 'teacher',
            ]
        );

        // Create courses
        $subjectModels = Subject::all();
        $courses = [];
        foreach ($subjectModels as $subject) {
            $course = Course::firstOrCreate(
                ['subject_id' => $subject->id],
                [
                    'title' => $subject->name . ' - Class 10A',
                    'description' => 'Course for ' . $subject->name,
                    'teacher_id' => $teacher->id,
                ]
            );
            $courses[] = $course;
        }

        // Create student user
        $studentUser = User::firstOrCreate(
            ['email' => 'student@school.com'],
            [
                'name' => 'Student User',
                'password' => Hash::make('password'),
                'role' => 'student',
            ]
        );

        // Create student profile
        $student = Student::firstOrCreate(
            ['user_id' => $studentUser->id],
            [
                'student_id' => 'STU2024001',
                'class' => '10',
                'section' => 'A',
                'roll_number' => 1,
                'academic_year' => '2024-2025',
                'enrollment_date' => now()->subMonths(6),
                'date_of_birth' => now()->subYears(16),
                'gender' => 'male',
                'address' => '123 Main Street',
                'city' => 'New York',
                'state' => 'NY',
                'zip_code' => '10001',
                'country' => 'USA',
                'emergency_contact' => 'John Doe - +1234567890',
                'status' => 'active',
            ]
        );

        // Enroll student in courses
        foreach ($courses as $course) {
            Enrollment::firstOrCreate(
                [
                    'student_id' => $student->id,
                    'course_id' => $course->id,
                ],
                [
                    'subject_id' => $course->subject_id,
                    'enrollment_date' => now()->subMonths(5),
                    'status' => 'enrolled',
                ]
            );
        }

        // Create assignments
        foreach ($courses as $index => $course) {
            for ($i = 1; $i <= 3; $i++) {
                Assignment::firstOrCreate(
                    [
                        'course_id' => $course->id,
                        'title' => 'Assignment ' . $i . ' - ' . $course->title,
                    ],
                    [
                        'description' => 'Complete the exercises from chapter ' . $i,
                        'due_date' => now()->addDays(7 * $i),
                        'teacher_id' => $teacher->id,
                        'max_marks' => 100,
                    ]
                );
            }
        }

        // Create some submissions
        $assignments = Assignment::take(2)->get();
        foreach ($assignments as $assignment) {
            Submission::firstOrCreate(
                [
                    'student_id' => $student->id,
                    'assignment_id' => $assignment->id,
                ],
                [
                    'file_path' => 'assignments/sample.pdf',
                    'comments' => 'Completed assignment',
                    'submitted_at' => now()->subDays(2),
                    'marks_obtained' => 85,
                    'feedback' => 'Good work!',
                    'status' => 'graded',
                ]
            );
        }

        // Create attendance records
        foreach ($courses as $course) {
            for ($i = 0; $i < 30; $i++) {
                $status = $i % 10 == 0 ? 'absent' : 'present';
                Attendance::firstOrCreate(
                    [
                        'student_id' => $student->id,
                        'course_id' => $course->id,
                        'date' => now()->subDays($i),
                    ],
                    [
                        'status' => $status,
                        'remarks' => $status == 'absent' ? 'Sick leave' : null,
                    ]
                );
            }
        }

        // Create grade scores
        foreach ($courses as $course) {
            $percentage = rand(70, 95);
            $grade = $this->calculateGrade($percentage);
            
            GradeScore::firstOrCreate(
                [
                    'student_id' => $student->id,
                    'course_id' => $course->id,
                ],
                [
                    'marks_obtained' => $percentage,
                    'total_marks' => 100,
                    'percentage' => $percentage,
                    'grade' => $grade,
                    'remarks' => 'Good performance',
                ]
            );
        }

        // Create exams
        foreach ($courses as $course) {
            Exam::firstOrCreate(
                [
                    'course_id' => $course->id,
                    'title' => 'Midterm Exam - ' . $course->title,
                ],
                [
                    'description' => 'Midterm examination covering chapters 1-5',
                    'exam_date' => now()->addDays(15),
                    'start_time' => '09:00:00',
                    'end_time' => '12:00:00',
                    'total_marks' => 100,
                    'type' => 'midterm',
                    'status' => 'scheduled',
                ]
            );
        }

        // Create resources
        foreach ($courses as $course) {
            Resource::firstOrCreate(
                [
                    'course_id' => $course->id,
                    'title' => 'Lecture Notes - Chapter 1',
                ],
                [
                    'description' => 'Introduction and basic concepts',
                    'teacher_id' => $teacher->id,
                    'file_path' => 'resources/sample.pdf',
                    'file_type' => 'pdf',
                    'type' => 'lecture_notes',
                ]
            );
        }
    }

    private function calculateGrade($percentage)
    {
        if ($percentage >= 90) return 'A+';
        if ($percentage >= 85) return 'A';
        if ($percentage >= 80) return 'B+';
        if ($percentage >= 75) return 'B';
        if ($percentage >= 70) return 'C+';
        if ($percentage >= 65) return 'C';
        if ($percentage >= 60) return 'D';
        return 'F';
    }

    private function ensureSampleFiles(): void
    {
        $this->createSamplePdf('resources/sample.pdf', 'Sample Study Material');
        $this->createSamplePdf('assignments/sample.pdf', 'Sample Assignment Submission');
    }

    private function createSamplePdf(string $path, string $title): void
    {
        if (Storage::disk('public')->exists($path)) {
            return;
        }

        $safeTitle = preg_replace('/[^A-Za-z0-9 \\-]/', '', $title) ?: 'Sample Document';
        $pdf = "%PDF-1.4\n";
        $pdf .= "1 0 obj<< /Type /Catalog /Pages 2 0 R >>endobj\n";
        $pdf .= "2 0 obj<< /Type /Pages /Kids [3 0 R] /Count 1 >>endobj\n";
        $pdf .= "3 0 obj<< /Type /Page /Parent 2 0 R /MediaBox [0 0 595 842] /Contents 4 0 R /Resources << /Font << /F1 5 0 R >> >> >>endobj\n";
        $pdf .= "4 0 obj<< /Length 66 >>stream\n";
        $pdf .= "BT /F1 18 Tf 72 760 Td (" . $safeTitle . ") Tj ET\n";
        $pdf .= "endstream\n";
        $pdf .= "endobj\n";
        $pdf .= "5 0 obj<< /Type /Font /Subtype /Type1 /BaseFont /Helvetica >>endobj\n";
        $pdf .= "xref\n";
        $pdf .= "0 6\n";
        $pdf .= "0000000000 65535 f \n";
        $pdf .= "0000000010 00000 n \n";
        $pdf .= "0000000062 00000 n \n";
        $pdf .= "0000000120 00000 n \n";
        $pdf .= "0000000265 00000 n \n";
        $pdf .= "0000000382 00000 n \n";
        $pdf .= "trailer<< /Root 1 0 R /Size 6 >>\n";
        $pdf .= "startxref\n";
        $pdf .= "452\n";
        $pdf .= "%%EOF\n";

        Storage::disk('public')->put($path, $pdf);
    }
}
