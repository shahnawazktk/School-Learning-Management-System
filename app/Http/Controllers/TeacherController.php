<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Teacher;
use App\Models\Course;
use App\Models\Assignment;
use App\Models\Submission;
use App\Models\Attendance;
use App\Models\Exam;
use App\Models\GradeScore;
use App\Models\Resource;
use App\Models\Enrollment;
use App\Models\Student;

class TeacherController extends Controller
{
    private function getTeacher()
    {
        $teacher = Teacher::where('user_id', Auth::id())->first();
        if (!$teacher) {
            Auth::logout();
            abort(403, 'Teacher profile not found. Please contact administrator.');
        }
        return $teacher;
    }

    public function dashboard()
    {
        $teacher = $this->getTeacher();
        
        $courses = Course::where('teacher_id', Auth::id())->withCount('enrollments')->get();
        $totalStudents = Enrollment::whereIn('course_id', $courses->pluck('id'))->distinct('student_id')->count();
        $pendingSubmissions = Submission::whereHas('assignment', function($q) {
            $q->where('teacher_id', Auth::id());
        })->where('status', 'submitted')->whereNull('marks_obtained')->count();
        
        $recentAssignments = Assignment::where('teacher_id', Auth::id())
            ->with('course')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('teacher.dashboard', compact('teacher', 'courses', 'totalStudents', 'pendingSubmissions', 'recentAssignments'));
    }

    public function courses()
    {
        $teacher = $this->getTeacher();
        $courses = Course::where('teacher_id', Auth::id())
            ->withCount('enrollments', 'assignments')
            ->with('subject')
            ->get();

        return view('teacher.courses', compact('teacher', 'courses'));
    }

    public function assignments()
    {
        $teacher = $this->getTeacher();
        $assignments = Assignment::where('teacher_id', Auth::id())
            ->with(['course', 'submissions'])
            ->orderBy('due_date', 'desc')
            ->get();

        return view('teacher.assignments', compact('teacher', 'assignments'));
    }

    public function submissions()
    {
        $teacher = $this->getTeacher();
        $submissions = Submission::whereHas('assignment', function($q) {
            $q->where('teacher_id', Auth::id());
        })
        ->with(['student.user', 'assignment.course'])
        ->orderBy('submitted_at', 'desc')
        ->get();

        return view('teacher.submissions', compact('teacher', 'submissions'));
    }

    public function attendance()
    {
        $teacher = $this->getTeacher();
        $courses = Course::where('teacher_id', Auth::id())->get();
        
        $attendanceRecords = Attendance::whereIn('course_id', $courses->pluck('id'))
            ->with(['student.user', 'course'])
            ->orderBy('date', 'desc')
            ->get();

        return view('teacher.attendance', compact('teacher', 'courses', 'attendanceRecords'));
    }

    public function exams()
    {
        $teacher = $this->getTeacher();
        $exams = Exam::whereHas('course', function($q) {
            $q->where('teacher_id', Auth::id());
        })
        ->with(['course', 'gradeScores'])
        ->orderBy('exam_date', 'desc')
        ->get();

        return view('teacher.exams', compact('teacher', 'exams'));
    }

    public function profile()
    {
        $teacher = $this->getTeacher();
        $user = Auth::user();

        return view('teacher.profile', compact('teacher', 'user'));
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'department' => 'nullable|string|max:100',
            'qualification' => 'nullable|string|max:200',
            'experience' => 'nullable|integer',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'zip_code' => 'nullable|string|max:20',
            'emergency_contact' => 'nullable|string|max:200',
        ]);

        $teacher = $this->getTeacher();
        $teacher->update($request->only(['department', 'qualification', 'experience', 'address', 'city', 'state', 'zip_code', 'emergency_contact']));

        return redirect()->route('teacher.profile')->with('success', 'Profile updated successfully!');
    }

    public function gradeSubmission(Request $request, $submissionId)
    {
        $request->validate([
            'marks_obtained' => 'required|numeric|min:0',
            'feedback' => 'nullable|string|max:1000'
        ]);

        $submission = Submission::findOrFail($submissionId);
        
        if ($submission->assignment->teacher_id != Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $submission->update([
            'marks_obtained' => $request->marks_obtained,
            'feedback' => $request->feedback,
            'status' => 'graded'
        ]);

        GradeScore::create([
            'student_id' => $submission->student_id,
            'course_id' => $submission->assignment->course_id,
            'assignment_id' => $submission->assignment_id,
            'marks_obtained' => $request->marks_obtained,
            'total_marks' => $submission->assignment->max_marks,
            'percentage' => ($request->marks_obtained / $submission->assignment->max_marks) * 100,
            'grade' => $this->calculateGrade(($request->marks_obtained / $submission->assignment->max_marks) * 100),
        ]);

        return response()->json(['success' => 'Submission graded successfully!']);
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
}
