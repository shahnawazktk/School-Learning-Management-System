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

    public function dashboard(Request $request)
    {
        $teacher = $this->getTeacher();

        $period = $request->string('period')->toString();
        $allowedPeriods = ['today', 'week', 'month', 'all'];
        $selectedPeriod = in_array($period, $allowedPeriods, true) ? $period : 'week';

        $courseOptions = Course::where('teacher_id', Auth::id())
            ->orderBy('title')
            ->get(['id', 'title']);
        $selectedCourseId = (int) $request->integer('course_id');
        $selectedCourseId = $courseOptions->contains('id', $selectedCourseId) ? $selectedCourseId : null;

        $rangeStart = null;
        $rangeEnd = null;
        $periodLabel = 'This Week';

        if ($selectedPeriod === 'today') {
            $rangeStart = now()->startOfDay();
            $rangeEnd = now()->endOfDay();
            $periodLabel = 'Today';
        } elseif ($selectedPeriod === 'week') {
            $rangeStart = now()->startOfWeek();
            $rangeEnd = now()->endOfWeek();
            $periodLabel = 'This Week';
        } elseif ($selectedPeriod === 'month') {
            $rangeStart = now()->startOfMonth();
            $rangeEnd = now()->endOfMonth();
            $periodLabel = 'This Month';
        } else {
            $periodLabel = 'All Time';
        }

        $applyRange = function ($query, $column) use ($rangeStart, $rangeEnd) {
            if ($rangeStart && $rangeEnd) {
                $query->whereBetween($column, [$rangeStart, $rangeEnd]);
            }
            return $query;
        };

        $coursesQuery = Course::where('teacher_id', Auth::id())
            ->withCount('enrollments')
            ->with('subject');

        if ($selectedCourseId) {
            $coursesQuery->where('id', $selectedCourseId);
        }

        $courses = $coursesQuery->get();
        $courseIds = $courses->pluck('id');
        $totalStudents = Enrollment::whereIn('course_id', $courseIds)->distinct('student_id')->count();

        $pendingSubmissionsQuery = Submission::whereHas('assignment', function($q) use ($courseIds) {
            $q->where('teacher_id', Auth::id());
            if ($courseIds->isNotEmpty()) {
                $q->whereIn('course_id', $courseIds);
            }
        })->where('status', 'submitted')->whereNull('marks_obtained');

        $applyRange($pendingSubmissionsQuery, 'submitted_at');
        $pendingSubmissions = (clone $pendingSubmissionsQuery)->count();
        $overdueGrading = (clone $pendingSubmissionsQuery)->whereHas('assignment', function($q) {
            $q->whereNotNull('due_date')->where('due_date', '<', now());
        })->count();
        $gradedInPeriod = Submission::whereHas('assignment', function($q) use ($courseIds) {
            $q->where('teacher_id', Auth::id());
            if ($courseIds->isNotEmpty()) {
                $q->whereIn('course_id', $courseIds);
            }
        })->where('status', 'graded')
            ->when($rangeStart && $rangeEnd, fn ($query) => $query->whereBetween('updated_at', [$rangeStart, $rangeEnd]))
            ->count();
        
        $recentAssignments = Assignment::where('teacher_id', Auth::id())
            ->when($selectedCourseId, fn ($q) => $q->where('course_id', $selectedCourseId))
            ->when($rangeStart && $rangeEnd, fn ($query) => $query->whereBetween('created_at', [$rangeStart, $rangeEnd]))
            ->with('course')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $gradingQueue = Submission::query()
            ->select('submissions.*')
            ->join('assignments', 'assignments.id', '=', 'submissions.assignment_id')
            ->where('assignments.teacher_id', Auth::id())
            ->when($selectedCourseId, fn ($q) => $q->where('assignments.course_id', $selectedCourseId))
            ->where('submissions.status', 'submitted')
            ->whereNull('submissions.marks_obtained')
            ->when($rangeStart && $rangeEnd, fn ($query) => $query->whereBetween('submissions.submitted_at', [$rangeStart, $rangeEnd]))
            ->with(['student.user', 'assignment.course'])
            ->orderBy('assignments.due_date')
            ->orderBy('submissions.submitted_at')
            ->take(8)
            ->get();

        $upcomingAssignments = Assignment::where('teacher_id', Auth::id())
            ->with('course')
            ->when($selectedCourseId, fn ($q) => $q->where('course_id', $selectedCourseId))
            ->whereBetween('due_date', [now(), now()->copy()->addDays(14)])
            ->orderBy('due_date')
            ->take(6)
            ->get();

        $upcomingExams = Exam::whereHas('course', function($q) {
            $q->where('teacher_id', Auth::id());
        })
            ->with('course')
            ->when($selectedCourseId, fn ($q) => $q->where('course_id', $selectedCourseId))
            ->whereBetween('exam_date', [now()->toDateString(), now()->copy()->addDays(14)->toDateString()])
            ->orderBy('exam_date')
            ->take(6)
            ->get();

        $pendingByCourse = collect();
        $avgByCourse = collect();

        if ($courseIds->isNotEmpty()) {
            $pendingByCourse = Submission::query()
                ->join('assignments', 'assignments.id', '=', 'submissions.assignment_id')
                ->whereIn('assignments.course_id', $courseIds)
                ->where('submissions.status', 'submitted')
                ->whereNull('submissions.marks_obtained')
                ->when($rangeStart && $rangeEnd, fn ($query) => $query->whereBetween('submissions.submitted_at', [$rangeStart, $rangeEnd]))
                ->groupBy('assignments.course_id')
                ->selectRaw('assignments.course_id as course_id, COUNT(*) as total_pending')
                ->get()
                ->mapWithKeys(function ($row) {
                    return [(int) $row->course_id => (int) $row->total_pending];
                });

            $avgByCourse = GradeScore::whereIn('course_id', $courseIds)
                ->when($rangeStart && $rangeEnd, fn ($query) => $query->whereBetween('created_at', [$rangeStart, $rangeEnd]))
                ->groupBy('course_id')
                ->selectRaw('course_id, AVG(percentage) as avg_percentage')
                ->get()
                ->mapWithKeys(function ($row) {
                    return [(int) $row->course_id => round((float) $row->avg_percentage, 1)];
                });
        }

        $coursePerformance = $courses->map(function ($course) use ($pendingByCourse, $avgByCourse) {
            $course->pending_grading_count = $pendingByCourse->get($course->id, 0);
            $course->avg_percentage = $avgByCourse->get($course->id);
            return $course;
        })->sortByDesc('enrollments_count')->values();

        $calendarItems = collect();

        foreach ($upcomingAssignments as $assignment) {
            $calendarItems->push([
                'type' => 'Assignment Due',
                'title' => $assignment->title,
                'course' => optional($assignment->course)->title,
                'date' => $assignment->due_date,
                'badge' => 'primary',
                'icon' => 'fa-file-lines',
            ]);
        }

        foreach ($upcomingExams as $exam) {
            $calendarItems->push([
                'type' => 'Exam',
                'title' => $exam->title,
                'course' => optional($exam->course)->title,
                'date' => $exam->exam_date,
                'badge' => 'warning',
                'icon' => 'fa-pen-ruler',
            ]);
        }

        $calendarItems = $calendarItems->sortBy('date')->take(10)->values();

        return view('teacher.dashboard', compact(
            'teacher',
            'courses',
            'totalStudents',
            'pendingSubmissions',
            'recentAssignments',
            'overdueGrading',
            'gradedInPeriod',
            'gradingQueue',
            'coursePerformance',
            'calendarItems',
            'courseOptions',
            'selectedCourseId',
            'selectedPeriod',
            'periodLabel'
        ));
    }

    public function courses()
    {
        $teacher = $this->getTeacher();
        $courses = Course::where('teacher_id', Auth::id())
            ->withCount('enrollments', 'assignments')
            ->with('subject')
            ->orderBy('title')
            ->get();

        $courseIds = $courses->pluck('id');

        $pendingByCourse = collect();
        $upcomingByCourse = collect();
        $gradingCoverageByCourse = collect();

        if ($courseIds->isNotEmpty()) {
            $pendingByCourse = Submission::query()
                ->join('assignments', 'assignments.id', '=', 'submissions.assignment_id')
                ->whereIn('assignments.course_id', $courseIds)
                ->where('submissions.status', 'submitted')
                ->whereNull('submissions.marks_obtained')
                ->groupBy('assignments.course_id')
                ->selectRaw('assignments.course_id as course_id, COUNT(*) as total_pending')
                ->get()
                ->mapWithKeys(function ($row) {
                    return [(int) $row->course_id => (int) $row->total_pending];
                });

            $upcomingByCourse = Assignment::query()
                ->whereIn('course_id', $courseIds)
                ->whereNotNull('due_date')
                ->whereBetween('due_date', [now(), now()->copy()->addDays(7)])
                ->groupBy('course_id')
                ->selectRaw('course_id, COUNT(*) as total_upcoming')
                ->get()
                ->mapWithKeys(function ($row) {
                    return [(int) $row->course_id => (int) $row->total_upcoming];
                });

            $gradingCoverageByCourse = Submission::query()
                ->join('assignments', 'assignments.id', '=', 'submissions.assignment_id')
                ->whereIn('assignments.course_id', $courseIds)
                ->groupBy('assignments.course_id')
                ->selectRaw('assignments.course_id as course_id, COUNT(*) as total_submissions, SUM(CASE WHEN submissions.marks_obtained IS NOT NULL THEN 1 ELSE 0 END) as graded_submissions')
                ->get()
                ->mapWithKeys(function ($row) {
                    $total = (int) $row->total_submissions;
                    $graded = (int) $row->graded_submissions;
                    return [
                        (int) $row->course_id => [
                            'total' => $total,
                            'graded' => $graded,
                            'percent' => $total > 0 ? (int) round(($graded / $total) * 100) : 0,
                        ],
                    ];
                });
        }

        $courses = $courses->map(function ($course) use ($pendingByCourse, $upcomingByCourse, $gradingCoverageByCourse) {
            $course->pending_reviews = $pendingByCourse->get($course->id, 0);
            $course->upcoming_deadlines = $upcomingByCourse->get($course->id, 0);
            $course->grading_coverage = $gradingCoverageByCourse->get($course->id, [
                'total' => 0,
                'graded' => 0,
                'percent' => 0,
            ]);

            return $course;
        });

        $totalCourses = $courses->count();
        $totalStudents = $courses->sum('enrollments_count');
        $totalAssignments = $courses->sum('assignments_count');
        $pendingReviews = $courses->sum('pending_reviews');
        $upcomingDeadlines = $courses->sum('upcoming_deadlines');
        $atRiskCourses = $courses->where('pending_reviews', '>=', 5)->count();
        $avgGradingCoverage = $courses->avg(function ($course) {
            return data_get($course->grading_coverage, 'percent', 0);
        }) ?? 0;

        return view('teacher.courses', compact(
            'teacher',
            'courses',
            'totalCourses',
            'totalStudents',
            'totalAssignments',
            'pendingReviews',
            'upcomingDeadlines',
            'atRiskCourses',
            'avgGradingCoverage'
        ));
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
            'profile_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $teacher = $this->getTeacher();
        $payload = $request->only(['department', 'qualification', 'experience', 'address', 'city', 'state', 'zip_code', 'emergency_contact']);

        if ($request->hasFile('profile_image')) {
            if (!empty($teacher->profile_image)) {
                Storage::disk('public')->delete($teacher->profile_image);
            }

            $payload['profile_image'] = $request->file('profile_image')->store('teachers/profiles', 'public');
        }

        $teacher->update($payload);

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
