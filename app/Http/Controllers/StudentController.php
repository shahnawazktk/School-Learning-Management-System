<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Student;
use App\Models\Enrollment;
use App\Models\Assignment;
use App\Models\Submission;
use App\Models\Attendance;
use App\Models\Grade;
use App\Models\Resource;
use App\Models\Course;
use App\Models\Subject;

class StudentController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $student = Student::where('user_id', $user->id)->first();

        if (!$student) {
            return redirect()->route('login')->with('error', 'Student profile not found.');
        }

        // Get student's enrollments
        $enrollments = Enrollment::where('student_id', $student->id)
            ->with(['course', 'subject'])
            ->get();

        // Get pending assignments
        $pendingAssignments = Assignment::whereHas('enrollments', function($query) use ($student) {
            $query->where('student_id', $student->id);
        })
        ->where('due_date', '>', now())
        ->whereDoesntHave('submissions', function($query) use ($student) {
            $query->where('student_id', $student->id);
        })
        ->with('course')
        ->take(5)
        ->get();

        // Get recent submissions
        $recentSubmissions = Submission::where('student_id', $student->id)
            ->with(['assignment', 'grade'])
            ->orderBy('submitted_at', 'desc')
            ->take(5)
            ->get();

        // Calculate attendance percentage
        $totalClasses = Attendance::where('student_id', $student->id)->count();
        $presentClasses = Attendance::where('student_id', $student->id)
            ->where('status', 'present')
            ->count();
        $attendancePercentage = $totalClasses > 0 ? round(($presentClasses / $totalClasses) * 100, 1) : 0;

        // Get average grade
        $grades = Grade::where('student_id', $student->id)->get();
        $averageGrade = $grades->avg('percentage') ?? 0;

        return view('student.dashboard', compact(
            'student',
            'enrollments',
            'pendingAssignments',
            'recentSubmissions',
            'attendancePercentage',
            'averageGrade'
        ));
    }

    public function subjects()
    {
        $user = Auth::user();
        $student = Student::where('user_id', $user->id)->first();

        $enrollments = Enrollment::where('student_id', $student->id)
            ->with(['course', 'subject.teacher'])
            ->get();

        return view('student.subjects', compact('student', 'enrollments'));
    }

    public function assignments()
    {
        $user = Auth::user();
        $student = Student::where('user_id', $user->id)->first();

        $assignments = Assignment::whereHas('enrollments', function($query) use ($student) {
            $query->where('student_id', $student->id);
        })
        ->with(['course', 'submissions' => function($query) use ($student) {
            $query->where('student_id', $student->id);
        }])
        ->orderBy('due_date', 'desc')
        ->get();

        return view('student.assignments', compact('student', 'assignments'));
    }

    public function attendance()
    {
        $user = Auth::user();
        $student = Student::where('user_id', $user->id)->first();

        $attendanceRecords = Attendance::where('student_id', $student->id)
            ->with('course')
            ->orderBy('date', 'desc')
            ->get();

        // Calculate attendance statistics
        $totalClasses = $attendanceRecords->count();
        $presentClasses = $attendanceRecords->where('status', 'present')->count();
        $attendancePercentage = $totalClasses > 0 ? round(($presentClasses / $totalClasses) * 100, 1) : 0;

        // Group by month for chart
        $monthlyAttendance = $attendanceRecords->groupBy(function($record) {
            return $record->date->format('M Y');
        })->map(function($monthRecords) {
            $total = $monthRecords->count();
            $present = $monthRecords->where('status', 'present')->count();
            return $total > 0 ? round(($present / $total) * 100, 1) : 0;
        });

        return view('student.attendance', compact(
            'student',
            'attendanceRecords',
            'attendancePercentage',
            'monthlyAttendance'
        ));
    }

    public function results()
    {
        $user = Auth::user();
        $student = Student::where('user_id', $user->id)->first();

        $grades = Grade::where('student_id', $student->id)
            ->with(['course', 'assignment'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Calculate overall statistics
        $averagePercentage = $grades->avg('percentage') ?? 0;
        $totalSubjects = $grades->unique('course_id')->count();

        // Grade distribution
        $gradeDistribution = [
            'A+' => $grades->where('grade', 'A+')->count(),
            'A' => $grades->where('grade', 'A')->count(),
            'B+' => $grades->where('grade', 'B+')->count(),
            'B' => $grades->where('grade', 'B')->count(),
            'C+' => $grades->where('grade', 'C+')->count(),
            'C' => $grades->where('grade', 'C')->count(),
            'D' => $grades->where('grade', 'D')->count(),
            'F' => $grades->where('grade', 'F')->count(),
        ];

        return view('student.results', compact(
            'student',
            'grades',
            'averagePercentage',
            'totalSubjects',
            'gradeDistribution'
        ));
    }

    public function resources()
    {
        $user = Auth::user();
        $student = Student::where('user_id', $user->id)->first();

        $enrollments = Enrollment::where('student_id', $student->id)->get();

        $resources = Resource::whereIn('course_id', $enrollments->pluck('course_id'))
            ->with('course')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('student.resources', compact('student', 'resources'));
    }

    public function profile()
    {
        $user = Auth::user();
        $student = Student::where('user_id', $user->id)->first();

        return view('student.profile', compact('student', 'user'));
    }

    public function submitAssignment(Request $request, $assignmentId)
    {
        $request->validate([
            'file' => 'required|file|mimes:pdf,doc,docx,ppt,pptx,jpg,jpeg,png|max:10240', // 10MB max
            'comments' => 'nullable|string|max:1000'
        ]);

        $user = Auth::user();
        $student = Student::where('user_id', $user->id)->first();

        $assignment = Assignment::findOrFail($assignmentId);

        // Check if student is enrolled in the course
        $enrollment = Enrollment::where('student_id', $student->id)
            ->where('course_id', $assignment->course_id)
            ->first();

        if (!$enrollment) {
            return response()->json(['error' => 'You are not enrolled in this course.'], 403);
        }

        // Check if already submitted
        $existingSubmission = Submission::where('student_id', $student->id)
            ->where('assignment_id', $assignmentId)
            ->first();

        if ($existingSubmission) {
            return response()->json(['error' => 'You have already submitted this assignment.'], 400);
        }

        // Store file
        $filePath = $request->file('file')->store('assignments', 'public');

        // Create submission
        Submission::create([
            'student_id' => $student->id,
            'assignment_id' => $assignmentId,
            'file_path' => $filePath,
            'comments' => $request->comments,
            'submitted_at' => now(),
        ]);

        return response()->json(['success' => 'Assignment submitted successfully!']);
    }

    public function downloadResource($resourceId)
    {
        $resource = Resource::findOrFail($resourceId);

        $user = Auth::user();
        $student = Student::where('user_id', $user->id)->first();

        // Check if student has access to this resource
        $hasAccess = Enrollment::where('student_id', $student->id)
            ->where('course_id', $resource->course_id)
            ->exists();

        if (!$hasAccess) {
            abort(403, 'You do not have access to this resource.');
        }

        return response()->download(storage_path('app/public/' . $resource->file_path));
    }
}
