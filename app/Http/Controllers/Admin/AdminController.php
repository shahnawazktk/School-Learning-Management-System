<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Assignment;
use App\Models\Attendance;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Exam;
use App\Models\School;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Submission;
use App\Models\Teacher;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    // Admin Dashboard
    public function dashboard()
    {
        $now = now();

        $teacherCount = Teacher::count();
        $studentCount = Student::count();
        $subjectCount = Subject::count();
        $courseCount = Course::count();
        $enrollmentCount = Enrollment::where('status', 'enrolled')->count();
        $assignmentCount = Assignment::count();
        $pendingSubmissions = Submission::whereNull('marks_obtained')->count();
        $upcomingExams = Exam::whereDate('exam_date', '>=', $now->toDateString())->count();

        $newTeachersThisMonth = Teacher::whereYear('created_at', $now->year)
            ->whereMonth('created_at', $now->month)
            ->count();

        $newStudentsThisMonth = Student::whereYear('created_at', $now->year)
            ->whereMonth('created_at', $now->month)
            ->count();

        $newSubjectsThisMonth = Subject::whereYear('created_at', $now->year)
            ->whereMonth('created_at', $now->month)
            ->count();

        $classCount = Student::query()
            ->whereNotNull('class')
            ->distinct()
            ->count(DB::raw("CONCAT(class, '-', COALESCE(section, ''))"));

        $totalAttendance = Attendance::count();
        $presentAttendance = Attendance::where('status', 'present')->count();
        $attendanceRate = $totalAttendance > 0
            ? round(($presentAttendance / $totalAttendance) * 100, 1)
            : 0;

        $monthlyAttendanceLabels = [];
        $monthlyAttendanceData = [];

        for ($month = 1; $month <= 12; $month++) {
            $label = Carbon::create($now->year, $month, 1)->format('M');
            $monthlyAttendanceLabels[] = $label;

            $monthTotal = Attendance::whereYear('date', $now->year)
                ->whereMonth('date', $month)
                ->count();

            $monthPresent = Attendance::whereYear('date', $now->year)
                ->whereMonth('date', $month)
                ->where('status', 'present')
                ->count();

            $monthlyAttendanceData[] = $monthTotal > 0
                ? round(($monthPresent / $monthTotal) * 100, 1)
                : 0;
        }

        $recentActivity = collect()
            ->merge(
                Teacher::with('user')
                    ->latest()
                    ->take(4)
                    ->get()
                    ->map(function ($teacher) {
                        return [
                            'title' => 'New teacher onboarded',
                            'description' => optional($teacher->user)->name . ' joined as faculty.',
                            'time' => $teacher->created_at,
                            'icon' => 'fa-chalkboard-teacher',
                        ];
                    })
            )
            ->merge(
                Student::with('user')
                    ->latest()
                    ->take(4)
                    ->get()
                    ->map(function ($student) {
                        return [
                            'title' => 'New student registered',
                            'description' => optional($student->user)->name . ' enrolled in class ' . ($student->class ?? 'N/A') . '.',
                            'time' => $student->created_at,
                            'icon' => 'fa-user-graduate',
                        ];
                    })
            )
            ->merge(
                Assignment::latest()
                    ->take(4)
                    ->get()
                    ->map(function ($assignment) {
                        return [
                            'title' => 'Assignment published',
                            'description' => $assignment->title . ' is now live for students.',
                            'time' => $assignment->created_at,
                            'icon' => 'fa-book-open',
                        ];
                    })
            )
            ->sortByDesc('time')
            ->take(8)
            ->values();

        return view('admin.dashboard', compact(
            'teacherCount',
            'studentCount',
            'subjectCount',
            'courseCount',
            'classCount',
            'enrollmentCount',
            'assignmentCount',
            'pendingSubmissions',
            'upcomingExams',
            'attendanceRate',
            'newTeachersThisMonth',
            'newStudentsThisMonth',
            'newSubjectsThisMonth',
            'monthlyAttendanceLabels',
            'monthlyAttendanceData',
            'recentActivity'
        ));
    }

    // Admin Profile
    // public function profile()
    // {
    //     return view('admin.profile');
    // }
    public function profile()
{
    $school = School::first(); // assuming one school record
    return view('admin.profile', compact('school'));
}

public function updateProfile(Request $request)
{
    $request->validate([
        'school_name' => 'required|string|max:255',
        'school_address' => 'required|string|max:500',
        'school_contact' => 'required|string|max:20',
    ]);

    $school = School::first();
    $school->update([
        'name' => $request->school_name,
        'address' => $request->school_address,
        'contact' => $request->school_contact,
    ]);

    return back()->with('success', 'School information updated successfully!');
}


    // All Users
    public function users()
    {
        return view('admin.users.index');
    }

    // Settings
    public function settings()
    {
        return view('admin.settings');
    }

    // Logout
    public function logout(Request $request)
    {
        auth()->logout();
        return redirect('/login');
    }
}
