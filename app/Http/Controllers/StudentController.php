<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Student;
use App\Models\Enrollment;
use App\Models\Assignment;
use App\Models\Submission;
use App\Models\Attendance;
use App\Models\GradeScore;
use App\Models\Resource;
use App\Models\Course;
use App\Models\Subject;
use App\Models\Exam;
use Carbon\Carbon;

class StudentController extends Controller
{
    private function attendanceMarkingPolicy(): array
    {
        return [
            'window_start' => config('attendance.self_mark.window_start', '07:00'),
            'window_end' => config('attendance.self_mark.window_end', '21:00'),
            'allowed_ips' => config('attendance.self_mark.allowed_ips', []),
        ];
    }

    private function attendanceEligibility(): array
    {
        $policy = $this->attendanceMarkingPolicy();
        $now = now();
        $start = now()->setTimeFromTimeString($policy['window_start']);
        $end = now()->setTimeFromTimeString($policy['window_end']);

        if ($end->lessThan($start)) {
            $end->addDay();
        }

        if (!$now->between($start, $end)) {
            return [
                'allowed' => false,
                'reason' => 'Attendance can be marked only between ' . $start->format('h:i A') . ' and ' . $end->format('h:i A') . '.',
            ];
        }

        $allowedIps = collect($policy['allowed_ips'])
            ->filter(fn ($ip) => is_string($ip) && trim($ip) !== '')
            ->values();

        if ($allowedIps->isNotEmpty() && !$allowedIps->contains(request()->ip())) {
            return [
                'allowed' => false,
                'reason' => 'Attendance marking is restricted on this network.',
            ];
        }

        return ['allowed' => true, 'reason' => null];
    }

    private function getStudent()
    {
        $student = Student::where('user_id', Auth::id())->first();
        if (!$student) {
            Auth::logout();
            abort(403, 'Student profile not found. Please contact administrator.');
        }
        return $student;
    }

    public function dashboard()
    {
        $student = $this->getStudent();

        $enrollments = Enrollment::where('student_id', $student->id)
            ->with(['course.subject', 'subject'])
            ->get();

        $pendingAssignments = Assignment::whereHas('course.enrollments', function($query) use ($student) {
            $query->where('student_id', $student->id);
        })
        ->where('due_date', '>', now())
        ->whereDoesntHave('submissions', function($query) use ($student) {
            $query->where('student_id', $student->id);
        })
        ->with('course')
        ->orderBy('due_date', 'asc')
        ->take(5)
        ->get();

        $recentSubmissions = Submission::where('student_id', $student->id)
            ->with(['assignment.course'])
            ->orderBy('submitted_at', 'desc')
            ->take(5)
            ->get();

        $totalClasses = Attendance::where('student_id', $student->id)->count();
        $presentClasses = Attendance::where('student_id', $student->id)
            ->where('status', 'present')
            ->count();
        $attendancePercentage = $totalClasses > 0 ? round(($presentClasses / $totalClasses) * 100, 1) : 0;

        $grades = GradeScore::where('student_id', $student->id)->get();
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
        $student = $this->getStudent();

        $status = request('status');
        $search = trim((string) request('q'));

        $enrollmentQuery = Enrollment::where('student_id', $student->id)
            ->with(['course.subject', 'course.teacher', 'subject'])
            ->when(in_array($status, ['enrolled', 'completed', 'dropped']), function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($innerQuery) use ($search) {
                    $innerQuery
                        ->whereHas('course', function ($courseQuery) use ($search) {
                            $courseQuery->where('title', 'like', '%' . $search . '%');
                        })
                        ->orWhereHas('subject', function ($subjectQuery) use ($search) {
                            $subjectQuery
                                ->where('name', 'like', '%' . $search . '%')
                                ->orWhere('code', 'like', '%' . $search . '%');
                        })
                        ->orWhereHas('course.subject', function ($subjectQuery) use ($search) {
                            $subjectQuery
                                ->where('name', 'like', '%' . $search . '%')
                                ->orWhere('code', 'like', '%' . $search . '%');
                        });
                });
            });

        $enrollments = $enrollmentQuery->get();
        $courseIds = $enrollments->pluck('course_id')->filter()->unique()->values();

        $assignmentsByCourse = Assignment::whereIn('course_id', $courseIds)
            ->orderBy('due_date')
            ->get()
            ->groupBy('course_id');

        $submittedAssignments = Submission::where('student_id', $student->id)
            ->whereHas('assignment', function ($query) use ($courseIds) {
                $query->whereIn('course_id', $courseIds);
            })
            ->with('assignment:id,course_id')
            ->get()
            ->groupBy(function ($submission) {
                return optional($submission->assignment)->course_id;
            });

        $subjectCards = $enrollments->map(function ($enrollment) use ($assignmentsByCourse, $submittedAssignments) {
            $course = $enrollment->course;
            $subject = $enrollment->subject ?? optional($course)->subject;
            $courseId = $enrollment->course_id;

            $courseAssignments = $courseId ? ($assignmentsByCourse->get($courseId) ?? collect()) : collect();
            $submittedForCourse = $courseId ? ($submittedAssignments->get($courseId) ?? collect()) : collect();

            $totalAssignments = $courseAssignments->count();
            $submittedCount = $submittedForCourse->pluck('assignment_id')->unique()->count();
            $completion = $totalAssignments > 0 ? (int) round(($submittedCount / $totalAssignments) * 100) : 0;
            $nextDue = $courseAssignments->first(function ($assignment) {
                return $assignment->due_date && $assignment->due_date->isFuture();
            });

            return [
                'enrollment' => $enrollment,
                'course' => $course,
                'subject' => $subject,
                'teacher' => optional($course)->teacher,
                'total_assignments' => $totalAssignments,
                'submitted_assignments' => $submittedCount,
                'completion' => $completion,
                'next_due' => $nextDue,
            ];
        });

        $stats = [
            'total_subjects' => $enrollments->count(),
            'active_subjects' => $enrollments->where('status', 'enrolled')->count(),
            'total_credits' => $subjectCards->sum(function ($card) {
                return optional($card['subject'])->credits ?? 0;
            }),
            'average_progress' => (int) round($subjectCards->avg('completion') ?? 0),
        ];

        return view('student.subjects', compact('student', 'enrollments', 'subjectCards', 'stats', 'status', 'search'));
    }

    public function assignments()
    {
        $student = $this->getStudent();

        $search = trim((string) request('q'));
        $status = request('status');
        $courseId = request('course_id');
        $sort = request('sort', 'due_asc');

        $enrolledCourseIds = Enrollment::where('student_id', $student->id)
            ->pluck('course_id')
            ->filter()
            ->unique()
            ->values();

        $courseOptions = Course::whereIn('id', $enrolledCourseIds)
            ->orderBy('title')
            ->get(['id', 'title']);

        $query = Assignment::whereIn('course_id', $enrolledCourseIds)
            ->with([
                'course.subject',
                'submissions' => function ($submissionQuery) use ($student) {
                    $submissionQuery->where('student_id', $student->id)->latest('submitted_at');
                },
            ])
            ->when($search !== '', function ($assignmentQuery) use ($search) {
                $assignmentQuery->where(function ($innerQuery) use ($search) {
                    $innerQuery
                        ->where('title', 'like', '%' . $search . '%')
                        ->orWhere('description', 'like', '%' . $search . '%')
                        ->orWhereHas('course', function ($courseQuery) use ($search) {
                            $courseQuery->where('title', 'like', '%' . $search . '%');
                        });
                });
            })
            ->when($courseId, function ($assignmentQuery) use ($courseId) {
                $assignmentQuery->where('course_id', $courseId);
            });

        switch ($sort) {
            case 'due_desc':
                $query->orderBy('due_date', 'desc');
                break;
            case 'newest':
                $query->latest();
                break;
            case 'oldest':
                $query->oldest();
                break;
            default:
                $query->orderBy('due_date', 'asc');
                break;
        }

        $assignments = $query->get();

        $assignmentCards = $assignments->map(function ($assignment) {
            $submission = $assignment->submissions->first();
            $isSubmitted = (bool) $submission;
            $isOverdue = !$isSubmitted && $assignment->due_date && $assignment->due_date->isPast();
            $isLateSubmission = $isSubmitted && ($submission->status === 'late');
            $statusKey = $isSubmitted ? ($isLateSubmission ? 'late' : 'submitted') : ($isOverdue ? 'overdue' : 'pending');
            $daysLeft = $assignment->due_date ? now()->diffInDays($assignment->due_date, false) : null;

            return [
                'assignment' => $assignment,
                'submission' => $submission,
                'status_key' => $statusKey,
                'days_left' => $daysLeft,
            ];
        })->when(in_array($status, ['pending', 'submitted', 'overdue', 'late']), function ($cards) use ($status) {
            return $cards->where('status_key', $status)->values();
        });

        $stats = [
            'total' => $assignmentCards->count(),
            'pending' => $assignmentCards->where('status_key', 'pending')->count(),
            'submitted' => $assignmentCards->where('status_key', 'submitted')->count() + $assignmentCards->where('status_key', 'late')->count(),
            'overdue' => $assignmentCards->where('status_key', 'overdue')->count(),
            'avg_score' => $assignmentCards
                ->pluck('submission')
                ->filter(fn($submission) => $submission && !is_null($submission->marks_obtained))
                ->avg('marks_obtained'),
        ];

        return view('student.assignments', compact(
            'student',
            'assignmentCards',
            'stats',
            'search',
            'status',
            'courseId',
            'sort',
            'courseOptions'
        ));
    }

    public function attendance()
    {
        $student = $this->getStudent();
        $attendanceEligibility = $this->attendanceEligibility();
        $selectedMonth = request('month');
        $selectedMonth = (is_string($selectedMonth) && preg_match('/^\d{4}-(0[1-9]|1[0-2])$/', $selectedMonth))
            ? $selectedMonth
            : null;

        $enrolledCourses = Course::whereIn('id', Enrollment::where('student_id', $student->id)->pluck('course_id'))
            ->orderBy('title')
            ->get(['id', 'title']);

        $todayMarkedCourseIds = Attendance::where('student_id', $student->id)
            ->whereDate('date', now()->toDateString())
            ->pluck('course_id')
            ->all();

        $recordsQuery = Attendance::where('student_id', $student->id)->with('course');
        $statsQuery = Attendance::where('student_id', $student->id);

        if ($selectedMonth) {
            [$year, $month] = explode('-', $selectedMonth);
            $year = (int) $year;
            $month = (int) $month;

            $recordsQuery->whereYear('date', $year)->whereMonth('date', $month);
            $statsQuery->whereYear('date', $year)->whereMonth('date', $month);
        }

        $attendanceRecords = $recordsQuery
            ->orderBy('date', 'desc')
            ->paginate(10)
            ->withQueryString();

        $totalClasses = (clone $statsQuery)->count();
        $presentClasses = (clone $statsQuery)->where('status', 'present')->count();
        $absentClasses = (clone $statsQuery)->where('status', 'absent')->count();
        $attendancePercentage = $totalClasses > 0 ? round(($presentClasses / $totalClasses) * 100, 1) : 0;

        $selectedMonthLabel = $selectedMonth
            ? Carbon::createFromFormat('Y-m', $selectedMonth)->format('F Y')
            : 'All Months';

        $monthlyAttendance = Attendance::where('student_id', $student->id)
            ->selectRaw("DATE_FORMAT(date, '%Y-%m') as month_key")
            ->selectRaw("DATE_FORMAT(date, '%b %Y') as month_label")
            ->selectRaw('COUNT(*) as total_classes')
            ->selectRaw("SUM(CASE WHEN status = 'present' THEN 1 ELSE 0 END) as present_classes")
            ->selectRaw("SUM(CASE WHEN status = 'absent' THEN 1 ELSE 0 END) as absent_classes")
            ->selectRaw("SUM(CASE WHEN status = 'late' THEN 1 ELSE 0 END) as late_classes")
            ->selectRaw("SUM(CASE WHEN status = 'excused' THEN 1 ELSE 0 END) as excused_classes")
            ->groupByRaw("DATE_FORMAT(date, '%Y-%m'), DATE_FORMAT(date, '%b %Y')")
            ->orderBy('month_key', 'desc')
            ->get()
            ->map(function ($monthRow) {
                $total = (int) $monthRow->total_classes;
                $present = (int) $monthRow->present_classes;

                return [
                    'month_key' => $monthRow->month_key,
                    'month_label' => $monthRow->month_label,
                    'total_classes' => $total,
                    'present_classes' => $present,
                    'absent_classes' => (int) $monthRow->absent_classes,
                    'late_classes' => (int) $monthRow->late_classes,
                    'excused_classes' => (int) $monthRow->excused_classes,
                    'attendance_percentage' => $total > 0 ? round(($present / $total) * 100, 1) : 0,
                ];
            });

        return view('student.attendance', compact(
            'student',
            'attendanceRecords',
            'attendancePercentage',
            'monthlyAttendance',
            'enrolledCourses',
            'todayMarkedCourseIds',
            'attendanceEligibility',
            'selectedMonth',
            'selectedMonthLabel',
            'totalClasses',
            'presentClasses',
            'absentClasses'
        ));
    }

    public function markAttendance(Request $request)
    {
        $student = $this->getStudent();
        $attendanceEligibility = $this->attendanceEligibility();

        if (!$attendanceEligibility['allowed']) {
            return back()->with('error', $attendanceEligibility['reason']);
        }

        $validated = $request->validate([
            'course_id' => 'required|integer|exists:courses,id',
            'remarks' => 'nullable|string|max:255',
        ]);

        $isEnrolled = Enrollment::where('student_id', $student->id)
            ->where('course_id', $validated['course_id'])
            ->exists();

        if (!$isEnrolled) {
            return back()->with('error', 'You are not enrolled in the selected course.');
        }

        $alreadyMarked = Attendance::where('student_id', $student->id)
            ->where('course_id', $validated['course_id'])
            ->whereDate('date', now()->toDateString())
            ->exists();

        if ($alreadyMarked) {
            return back()->with('error', 'Attendance already marked for this course today.');
        }

        Attendance::create([
            'student_id' => $student->id,
            'course_id' => $validated['course_id'],
            'date' => now()->toDateString(),
            'status' => 'present',
            'remarks' => $validated['remarks'] ?? 'Self-marked by student (' . $request->ip() . ')',
        ]);

        return back()->with('success', 'Attendance marked successfully for today.');
    }

    public function results(Request $request)
    {
        $student = $this->getStudent();
        $resultData = $this->buildResultsData($student, $request);

        return view('student.results', [
            'student' => $student,
            ...$resultData,
        ]);
    }

    public function resultCard(Request $request)
    {
        $student = $this->getStudent();
        $resultData = $this->buildResultsData($student, $request);

        return view('student.result-card', [
            'student' => $student,
            'isDownload' => false,
            ...$resultData,
        ]);
    }

    public function downloadResultCard(Request $request)
    {
        $student = $this->getStudent();
        $resultData = $this->buildResultsData($student, $request);
        $fileName = 'result-card-' . $student->id . '-' . now()->format('Ymd-His') . '.pdf';

        $pdf = Pdf::loadView('student.result-card-pdf', [
            'student' => $student,
            ...$resultData,
        ])->setPaper('a4', 'portrait');

        return $pdf->download($fileName);
    }

    private function buildResultsData(Student $student, Request $request): array
    {
        $gradesQuery = GradeScore::where('student_id', $student->id)
            ->with(['course', 'assignment', 'exam']);

        $courseId = $request->integer('course_id');
        $type = $request->string('type')->toString();
        $type = in_array($type, ['assignment', 'exam'], true) ? $type : '';

        if ($courseId > 0) {
            $gradesQuery->where('course_id', $courseId);
        }

        if ($type === 'assignment') {
            $gradesQuery->whereNotNull('assignment_id');
        } elseif ($type === 'exam') {
            $gradesQuery->whereNotNull('exam_id');
        }

        $grades = $gradesQuery
            ->orderBy('created_at', 'desc')
            ->get();

        $courseIds = GradeScore::where('student_id', $student->id)
            ->whereNotNull('course_id')
            ->distinct()
            ->pluck('course_id');

        $courses = Course::whereIn('id', $courseIds)
            ->orderBy('title')
            ->get(['id', 'title']);

        $averagePercentage = $grades->avg('percentage') ?? 0;
        $totalSubjects = $grades->unique('course_id')->count();
        $passRate = $grades->count() > 0
            ? ($grades->where('percentage', '>=', 40)->count() / $grades->count()) * 100
            : 0;
        $highestPercentage = $grades->max('percentage') ?? 0;
        $lowestPercentage = $grades->min('percentage') ?? 0;

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

        return compact(
            'grades',
            'courses',
            'courseId',
            'type',
            'averagePercentage',
            'totalSubjects',
            'gradeDistribution',
            'passRate',
            'highestPercentage',
            'lowestPercentage'
        );
    }

    public function resources()
    {
        $student = $this->getStudent();

        $enrollments = Enrollment::where('student_id', $student->id)->get();

        $resources = Resource::whereIn('course_id', $enrollments->pluck('course_id'))
            ->with('course')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('student.resources', compact('student', 'resources'));
    }

    public function profile()
    {
        $student = $this->getStudent();
        $user = Auth::user();

        return view('student.profile', compact('student', 'user'));
    }

    public function submitAssignment(Request $request, $assignmentId)
    {
        $request->validate([
            'file' => 'required|file|mimes:pdf,doc,docx,ppt,pptx,jpg,jpeg,png,zip|max:10240',
            'comments' => 'nullable|string|max:1000'
        ]);

        $student = $this->getStudent();
        $assignment = Assignment::findOrFail($assignmentId);

        $enrollment = Enrollment::where('student_id', $student->id)
            ->where('course_id', $assignment->course_id)
            ->first();

        if (!$enrollment) {
            if ($request->expectsJson()) {
                return response()->json(['error' => 'You are not enrolled in this course.'], 403);
            }
            return back()->with('error', 'You are not enrolled in this course.');
        }

        $existingSubmission = Submission::where('student_id', $student->id)
            ->where('assignment_id', $assignmentId)
            ->first();

        if ($existingSubmission) {
            if ($request->expectsJson()) {
                return response()->json(['error' => 'You have already submitted this assignment.'], 400);
            }
            return back()->with('error', 'You have already submitted this assignment.');
        }

        $filePath = $request->file('file')->store('assignments', 'public');

        $status = now() > $assignment->due_date ? 'late' : 'submitted';

        Submission::create([
            'student_id' => $student->id,
            'assignment_id' => $assignmentId,
            'file_path' => $filePath,
            'comments' => $request->comments,
            'submitted_at' => now(),
            'status' => $status,
        ]);

        if ($request->expectsJson()) {
            return response()->json(['success' => 'Assignment submitted successfully!']);
        }
        return redirect()->route('student.dashboard')->with('success', 'Assignment submitted successfully!');
    }

    public function downloadResource($resourceId)
    {
        $resource = Resource::findOrFail($resourceId);
        $student = $this->getStudent();

        $hasAccess = Enrollment::where('student_id', $student->id)
            ->where('course_id', $resource->course_id)
            ->exists();

        if (!$hasAccess) {
            abort(403, 'You do not have access to this resource.');
        }

        $rawPath = trim((string) $resource->file_path);
        $normalizedPath = ltrim(str_replace('\\', '/', $rawPath), '/');

        if (str_starts_with($normalizedPath, 'storage/')) {
            $normalizedPath = substr($normalizedPath, 8);
        }

        $candidatePaths = [
            Storage::disk('public')->path($normalizedPath),
            storage_path('app/public/' . $normalizedPath),
            storage_path('app/' . $normalizedPath),
            public_path($normalizedPath),
            public_path('storage/' . $normalizedPath),
            base_path($normalizedPath),
        ];

        $resolvedPath = collect($candidatePaths)->first(function ($path) {
            return is_string($path) && is_file($path);
        });

        if (!$resolvedPath) {
            abort(404, 'Resource file not found on server. Please contact administrator.');
        }

        $downloadName = trim((string) $resource->title);
        $extension = pathinfo($resolvedPath, PATHINFO_EXTENSION);

        if ($downloadName === '') {
            $downloadName = basename($resolvedPath);
        } elseif ($extension !== '' && pathinfo($downloadName, PATHINFO_EXTENSION) === '') {
            $downloadName .= '.' . $extension;
        }

        return response()->download($resolvedPath, $downloadName);
    }

    public function exams()
    {
        $student = $this->getStudent();
        $examData = $this->buildExamData($student, request());

        return view('student.exams', [
            'student' => $student,
            ...$examData,
        ]);
    }

    public function downloadExamSchedule(Request $request)
    {
        $student = $this->getStudent();
        $examData = $this->buildExamData($student, $request);
        $exams = $examData['exams'];
        $fileName = 'exam-schedule-' . $student->id . '-' . now()->format('Ymd-His') . '.csv';

        return response()->streamDownload(function () use ($exams) {
            $handle = fopen('php://output', 'w');

            fputcsv($handle, [
                'Exam Title',
                'Course',
                'Exam Date',
                'Start Time',
                'End Time',
                'Type',
                'Status',
                'Marks Obtained',
                'Total Marks',
                'Grade',
                'Percentage',
            ]);

            foreach ($exams as $exam) {
                $gradeScore = $exam->gradeScores->first();

                fputcsv($handle, [
                    (string) $exam->title,
                    (string) ($exam->course->title ?? 'N/A'),
                    optional($exam->exam_date)->format('Y-m-d') ?? 'N/A',
                    $exam->start_time ? date('h:i A', strtotime($exam->start_time)) : 'N/A',
                    $exam->end_time ? date('h:i A', strtotime($exam->end_time)) : 'N/A',
                    ucfirst((string) ($exam->type ?? 'n/a')),
                    ucfirst((string) ($exam->status ?? 'n/a')),
                    $gradeScore ? $gradeScore->marks_obtained : 'N/A',
                    $gradeScore ? $gradeScore->total_marks : 'N/A',
                    $gradeScore ? $gradeScore->grade : 'N/A',
                    $gradeScore ? number_format((float) $gradeScore->percentage, 1) . '%' : 'N/A',
                ]);
            }

            fclose($handle);
        }, $fileName, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }

    public function downloadExamCalendar(Request $request)
    {
        $student = $this->getStudent();
        $examData = $this->buildExamData($student, $request);
        $exams = $examData['exams'];
        $fileName = 'exam-calendar-' . $student->id . '-' . now()->format('Ymd-His') . '.ics';

        return response()->streamDownload(function () use ($exams) {
            echo "BEGIN:VCALENDAR\r\n";
            echo "VERSION:2.0\r\n";
            echo "PRODID:-//LMS//Student Exam Calendar//EN\r\n";
            echo "CALSCALE:GREGORIAN\r\n";
            echo "METHOD:PUBLISH\r\n";

            foreach ($exams as $exam) {
                $start = $this->examDateTime($exam->exam_date, $exam->start_time, '00:00');
                $end = $this->examDateTime($exam->exam_date, $exam->end_time, '23:59');

                if (!$start || !$end) {
                    continue;
                }

                $uid = 'exam-' . $exam->id . '-student-' . auth()->id() . '@lms.local';
                $title = $this->escapeIcsText((string) $exam->title);
                $courseTitle = $this->escapeIcsText((string) ($exam->course->title ?? 'N/A'));
                $description = $this->escapeIcsText((string) ($exam->description ?? ''));
                $status = $this->escapeIcsText(ucfirst((string) ($exam->status ?? 'Unknown')));

                echo "BEGIN:VEVENT\r\n";
                echo "UID:{$uid}\r\n";
                echo "DTSTAMP:" . now()->utc()->format('Ymd\THis\Z') . "\r\n";
                echo "DTSTART:" . $start->utc()->format('Ymd\THis\Z') . "\r\n";
                echo "DTEND:" . $end->utc()->format('Ymd\THis\Z') . "\r\n";
                echo "SUMMARY:{$title}\r\n";
                echo "DESCRIPTION:Course: {$courseTitle}\\nStatus: {$status}\\n{$description}\r\n";
                echo "STATUS:CONFIRMED\r\n";
                echo "END:VEVENT\r\n";
            }

            echo "END:VCALENDAR\r\n";
        }, $fileName, [
            'Content-Type' => 'text/calendar; charset=UTF-8',
        ]);
    }

    public function examAdmitCard(int $exam)
    {
        $student = $this->getStudent();
        $examRecord = $this->resolveStudentExam($exam, $student);
        $gradeScore = $examRecord->gradeScores->first();

        return view('student.exam-admit-card', [
            'student' => $student,
            'exam' => $examRecord,
            'gradeScore' => $gradeScore,
        ]);
    }

    public function downloadExamAdmitCard(int $exam)
    {
        $student = $this->getStudent();
        $examRecord = $this->resolveStudentExam($exam, $student);
        $gradeScore = $examRecord->gradeScores->first();
        $fileName = 'admit-card-exam-' . $examRecord->id . '-' . now()->format('Ymd-His') . '.pdf';

        $pdf = Pdf::loadView('student.exam-admit-card-pdf', [
            'student' => $student,
            'exam' => $examRecord,
            'gradeScore' => $gradeScore,
        ])->setPaper('a4', 'portrait');

        return $pdf->download($fileName);
    }

    private function buildExamData(Student $student, Request $request): array
    {
        $baseQuery = Exam::query()
            ->whereHas('course.enrollments', function ($query) use ($student) {
                $query->where('student_id', $student->id);
            })
            ->with([
                'course',
                'gradeScores' => function ($query) use ($student) {
                    $query->where('student_id', $student->id);
                }
            ]);

        $q = trim($request->string('q')->toString());
        $status = strtolower(trim($request->string('status')->toString()));
        $type = strtolower(trim($request->string('type')->toString()));
        $sort = strtolower(trim($request->string('sort')->toString()));
        $sort = in_array($sort, ['upcoming', 'latest', 'oldest'], true) ? $sort : 'upcoming';

        $statusOptions = (clone $baseQuery)
            ->select('status')
            ->distinct()
            ->pluck('status')
            ->filter()
            ->values();

        $typeOptions = (clone $baseQuery)
            ->select('type')
            ->distinct()
            ->pluck('type')
            ->filter()
            ->values();

        $query = clone $baseQuery;

        if ($q !== '') {
            $query->where(function ($inner) use ($q) {
                $inner->where('title', 'like', '%' . $q . '%')
                    ->orWhere('description', 'like', '%' . $q . '%')
                    ->orWhereHas('course', function ($courseQuery) use ($q) {
                        $courseQuery->where('title', 'like', '%' . $q . '%');
                    });
            });
        }

        if ($status !== '') {
            $query->where('status', $status);
        }

        if ($type !== '') {
            $query->where('type', $type);
        }

        $exams = $query->get();

        $today = now()->startOfDay();

        if ($sort === 'latest') {
            $exams = $exams->sortByDesc(fn ($exam) => optional($exam->exam_date)->timestamp ?? 0)->values();
        } elseif ($sort === 'oldest') {
            $exams = $exams->sortBy(fn ($exam) => optional($exam->exam_date)->timestamp ?? PHP_INT_MAX)->values();
        } else {
            $exams = $exams->sortBy(function ($exam) use ($today) {
                $date = $exam->exam_date;
                $isPast = !$date || $date->lt($today);
                $timestamp = $date ? $date->timestamp : PHP_INT_MAX;
                return [$isPast ? 1 : 0, $timestamp];
            })->values();
        }

        $upcomingCount = $exams->filter(function ($exam) use ($today) {
            return $exam->exam_date && $exam->exam_date->gte($today) && $exam->status !== 'cancelled';
        })->count();

        $completedCount = $exams->where('status', 'completed')->count();
        $gradedCount = $exams->filter(fn ($exam) => $exam->gradeScores->isNotEmpty())->count();
        $avgScore = $exams->flatMap->gradeScores->avg('percentage') ?? 0;

        $nextExam = $exams->first(function ($exam) use ($today) {
            return $exam->exam_date && $exam->exam_date->gte($today) && $exam->status !== 'cancelled';
        });

        return compact(
            'exams',
            'q',
            'status',
            'type',
            'sort',
            'statusOptions',
            'typeOptions',
            'upcomingCount',
            'completedCount',
            'gradedCount',
            'avgScore',
            'nextExam'
        );
    }

    private function resolveStudentExam(int $examId, Student $student): Exam
    {
        return Exam::query()
            ->where('id', $examId)
            ->whereHas('course.enrollments', function ($query) use ($student) {
                $query->where('student_id', $student->id);
            })
            ->with([
                'course',
                'gradeScores' => function ($query) use ($student) {
                    $query->where('student_id', $student->id);
                }
            ])
            ->firstOrFail();
    }

    private function examDateTime($examDate, ?string $time, string $fallbackTime): ?Carbon
    {
        if (!$examDate) {
            return null;
        }

        try {
            return Carbon::parse($examDate->format('Y-m-d') . ' ' . ($time ?: $fallbackTime), config('app.timezone'));
        } catch (\Throwable $exception) {
            return null;
        }
    }

    private function escapeIcsText(string $value): string
    {
        return str_replace(
            ['\\', ';', ',', "\r\n", "\n", "\r"],
            ['\\\\', '\;', '\,', '\\n', '\\n', '\\n'],
            $value
        );
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'zip_code' => 'nullable|string|max:20',
            'emergency_contact' => 'nullable|string|max:200',
        ]);

        $student = $this->getStudent();
        $student->update($request->only(['address', 'city', 'state', 'zip_code', 'emergency_contact']));

        return redirect()->route('student.profile')->with('success', 'Profile updated successfully!');
    }
}
