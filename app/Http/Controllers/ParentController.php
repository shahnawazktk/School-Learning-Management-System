<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ParentModel;
use App\Models\Student;
use App\Models\Enrollment;
use App\Models\Assignment;
use App\Models\Submission;
use App\Models\Attendance;
use App\Models\GradeScore;
use App\Models\Exam;

class ParentController extends Controller
{
    private function getParent()
    {
        $parent = ParentModel::where('user_id', Auth::id())->first();
        if (!$parent) {
            abort(403, 'Parent profile not found. Please contact administrator.');
        }
        return $parent;
    }

    public function dashboard()
    {
        $parent = $this->getParent();
        $students = $parent->students()->with('user')->get();
        
        $childrenData = [];
        foreach ($students as $student) {
            $enrollments = Enrollment::where('student_id', $student->id)->count();
            $pendingAssignments = Submission::where('student_id', $student->id)
                ->where('status', 'pending')->count();
            $avgAttendance = Attendance::where('student_id', $student->id)
                ->where('status', 'present')->count();
            $totalAttendance = Attendance::where('student_id', $student->id)->count();
            $attendancePercentage = $totalAttendance > 0 ? round(($avgAttendance / $totalAttendance) * 100, 1) : 0;
            
            $avgGrade = GradeScore::where('student_id', $student->id)->avg('percentage');
            
            $childrenData[] = [
                'student' => $student,
                'enrollments' => $enrollments,
                'pendingAssignments' => $pendingAssignments,
                'attendancePercentage' => $attendancePercentage,
                'avgGrade' => round($avgGrade ?? 0, 1),
            ];
        }

        return view('parent.dashboard', compact('parent', 'childrenData'));
    }

    public function children()
    {
        $parent = $this->getParent();
        $students = $parent->students()->with(['user', 'enrollments.course'])->get();

        return view('parent.children', compact('parent', 'students'));
    }

    public function childDetails($studentId)
    {
        $parent = $this->getParent();
        $student = $parent->students()
            ->with(['user', 'enrollments.course.subject', 'attendances', 'submissions', 'gradeScores'])
            ->findOrFail($studentId);
        
        $recentGrades = GradeScore::where('student_id', $studentId)
            ->with(['course', 'assignment'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('parent.child-details', compact('parent', 'student', 'recentGrades'));
    }

    public function attendance($studentId)
    {
        $parent = $this->getParent();
        $student = $parent->students()->findOrFail($studentId);
        
        // Get paginated records for display
        $attendanceRecords = Attendance::where('student_id', $studentId)
            ->with('course')
            ->orderBy('date', 'desc')
            ->paginate(20);
        
        // Get totals from ALL records (not just the current page)
        $totalClasses = Attendance::where('student_id', $studentId)->count();
        $presentCount = Attendance::where('student_id', $studentId)->where('status', 'present')->count();
        $absentCount = Attendance::where('student_id', $studentId)->where('status', 'absent')->count();
        $lateCount = Attendance::where('student_id', $studentId)->where('status', 'late')->count();
        $attendancePercentage = $totalClasses > 0 ? round(($presentCount / $totalClasses) * 100, 1) : 0;

        return view('parent.attendance', compact('parent', 'student', 'attendanceRecords', 'totalClasses', 'presentCount', 'absentCount', 'lateCount', 'attendancePercentage'));
    }

    public function grades($studentId)
    {
        $parent = $this->getParent();
        $student = $parent->students()->findOrFail($studentId);
        
        // Get paginated records for display
        $grades = GradeScore::where('student_id', $studentId)
            ->with(['course', 'assignment', 'exam'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);
        
        // Get average from ALL records (not just the current page)
        $avgPercentage = GradeScore::where('student_id', $studentId)->avg('percentage');
        
        // Get grade distribution counts from ALL records (not just the current page)
        $totalGrades = GradeScore::where('student_id', $studentId)->count();
        $excellentCount = GradeScore::where('student_id', $studentId)->where('percentage', '>=', 90)->count();
        $goodCount = GradeScore::where('student_id', $studentId)->where('percentage', '>=', 75)->where('percentage', '<', 90)->count();
        $averageCount = GradeScore::where('student_id', $studentId)->where('percentage', '>=', 60)->where('percentage', '<', 75)->count();
        $needsWorkCount = GradeScore::where('student_id', $studentId)->where('percentage', '<', 60)->count();

        return view('parent.grades', compact('parent', 'student', 'grades', 'avgPercentage', 'excellentCount', 'goodCount', 'averageCount', 'needsWorkCount', 'totalGrades'));
    }

    public function assignments($studentId)
    {
        $parent = $this->getParent();
        $student = $parent->students()->findOrFail($studentId);
        
        $enrollments = Enrollment::where('student_id', $studentId)->pluck('course_id');
        $assignments = Assignment::whereIn('course_id', $enrollments)
            ->with(['course', 'submissions' => function($q) use ($studentId) {
                $q->where('student_id', $studentId);
            }])
            ->orderBy('due_date', 'desc')
            ->get();

        return view('parent.assignments', compact('parent', 'student', 'assignments'));
    }

    public function exams($studentId)
    {
        $parent = $this->getParent();
        $student = $parent->students()->findOrFail($studentId);
        
        $enrollments = Enrollment::where('student_id', $studentId)->pluck('course_id');
        $exams = Exam::whereIn('course_id', $enrollments)
            ->with(['course', 'gradeScores' => function($q) use ($studentId) {
                $q->where('student_id', $studentId);
            }])
            ->orderBy('exam_date', 'desc')
            ->get();

        return view('parent.exams', compact('parent', 'student', 'exams'));
    }

    public function profile()
    {
        $parent = $this->getParent();
        $user = Auth::user();

        return view('parent.profile', compact('parent', 'user'));
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'relationship' => 'nullable|string|max:50',
            'occupation' => 'nullable|string|max:100',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'zip_code' => 'nullable|string|max:20',
            'emergency_contact' => 'nullable|string|max:200',
        ]);

        $parent = $this->getParent();
        $parent->update($request->only(['relationship', 'occupation', 'phone', 'address', 'city', 'state', 'zip_code', 'emergency_contact']));

        return redirect()->route('parent.profile')->with('success', 'Profile updated successfully!');
    }

    public function notifications()
    {
        $parent = $this->getParent();
        $user = Auth::user();
        
        // Get notifications for the parent (you can customize this based on your notification system)
        $notifications = $user->notifications()->orderBy('created_at', 'desc')->paginate(20);

        return view('parent.notifications', compact('parent', 'notifications'));
    }

    public function settings()
    {
        $parent = $this->getParent();
        $user = Auth::user();

        return view('parent.settings', compact('parent', 'user'));
    }

    /**
     * Redirect to first child's attendance page
     */
    public function redirectToAttendance()
    {
        $parent = $this->getParent();
        $firstChild = $parent->students()->first();
        
        if (!$firstChild) {
            return redirect()->route('parent.children')->with('error', 'No children found.');
        }
        
        return redirect()->route('parent.child.attendance', $firstChild->id);
    }

    /**
     * Redirect to first child's grades page
     */
    public function redirectToGrades()
    {
        $parent = $this->getParent();
        $firstChild = $parent->students()->first();
        
        if (!$firstChild) {
            return redirect()->route('parent.children')->with('error', 'No children found.');
        }
        
        return redirect()->route('parent.child.grades', $firstChild->id);
    }

    /**
     * Redirect to first child's assignments page
     */
    public function redirectToAssignments()
    {
        $parent = $this->getParent();
        $firstChild = $parent->students()->first();
        
        if (!$firstChild) {
            return redirect()->route('parent.children')->with('error', 'No children found.');
        }
        
        return redirect()->route('parent.child.assignments', $firstChild->id);
    }

    /**
     * Redirect to first child's exams page
     */
    public function redirectToExams()
    {
        $parent = $this->getParent();
        $firstChild = $parent->students()->first();
        
        if (!$firstChild) {
            return redirect()->route('parent.children')->with('error', 'No children found.');
        }
        
        return redirect()->route('parent.child.exams', $firstChild->id);
    }
}
