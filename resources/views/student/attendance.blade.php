@extends('layouts.student.app')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container-fluid p-4">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger mb-3">
            {{ $errors->first() }}
        </div>
    @endif

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white">
            <h5 class="mb-0">Mark Today Attendance</h5>
        </div>
        <div class="card-body">
            @if(!$attendanceEligibility['allowed'])
                <div class="alert alert-warning">
                    {{ $attendanceEligibility['reason'] }}
                </div>
            @endif
            <p class="text-muted mb-3">Date: {{ now()->format('M d, Y') }}</p>
            <form method="POST" action="{{ route('student.attendance.mark') }}" class="row g-3">
                @csrf
                <div class="col-md-5">
                    <label for="course_id" class="form-label">Select Course</label>
                    <select name="course_id" id="course_id" class="form-select" required @disabled(!$attendanceEligibility['allowed'])>
                        <option value="">Choose course...</option>
                        @foreach($enrolledCourses as $course)
                            <option value="{{ $course->id }}" @disabled(in_array($course->id, $todayMarkedCourseIds))>
                                {{ $course->title }}
                                @if(in_array($course->id, $todayMarkedCourseIds))
                                    (Already marked today)
                                @endif
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-5">
                    <label for="remarks" class="form-label">Remarks (optional)</label>
                    <input type="text" name="remarks" id="remarks" class="form-control" maxlength="255" placeholder="e.g., Attended live class" @disabled(!$attendanceEligibility['allowed'])>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button class="btn btn-primary w-100" type="submit" @disabled(!$attendanceEligibility['allowed'])>Mark Present</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Stats -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <h2 class="text-primary">{{ $attendancePercentage }}%</h2>
                    <p class="text-muted mb-0">{{ $selectedMonthLabel }} Attendance</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <h2 class="text-success">{{ $presentClasses }}</h2>
                    <p class="text-muted mb-0">Present Days</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <h2 class="text-danger">{{ $absentClasses }}</h2>
                    <p class="text-muted mb-0">Absent Days</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Monthly Attendance Tracker</h5>
            @if($selectedMonth)
                <a href="{{ route('student.attendance') }}" class="btn btn-sm btn-outline-secondary">Show All Months</a>
            @endif
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Month</th>
                            <th>Total Classes</th>
                            <th>Present</th>
                            <th>Absent</th>
                            <th>Late</th>
                            <th>Attendance %</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($monthlyAttendance as $month)
                            <tr>
                                <td>{{ $month['month_label'] }}</td>
                                <td>{{ $month['total_classes'] }}</td>
                                <td>{{ $month['present_classes'] }}</td>
                                <td>{{ $month['absent_classes'] }}</td>
                                <td>{{ $month['late_classes'] }}</td>
                                <td>
                                    <span class="badge bg-primary">{{ $month['attendance_percentage'] }}%</span>
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('student.attendance', ['month' => $month['month_key']]) }}"
                                       class="btn btn-sm {{ $selectedMonth === $month['month_key'] ? 'btn-primary' : 'btn-outline-primary' }}">
                                        {{ $selectedMonth === $month['month_key'] ? 'Tracking' : 'Track Month' }}
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">No monthly attendance data available.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Attendance Records -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Attendance Records - {{ $selectedMonthLabel }}</h5>
            <span class="text-muted small">Total: {{ $totalClasses }}</span>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Course</th>
                            <th>Status</th>
                            <th>Remarks</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($attendanceRecords as $record)
                            <tr>
                                <td>{{ $record->date->format('M d, Y') }}</td>
                                <td>{{ $record->course->title ?? 'N/A' }}</td>
                                <td>
                                    @if($record->status == 'present')
                                        <span class="badge bg-success">Present</span>
                                    @elseif($record->status == 'absent')
                                        <span class="badge bg-danger">Absent</span>
                                    @elseif($record->status == 'late')
                                        <span class="badge bg-warning text-dark">Late</span>
                                    @else
                                        <span class="badge bg-info">{{ ucfirst($record->status) }}</span>
                                    @endif
                                </td>
                                <td>{{ $record->remarks ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted">No attendance records</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($attendanceRecords->hasPages())
                <div class="d-flex justify-content-end mt-3">
                    {{ $attendanceRecords->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
