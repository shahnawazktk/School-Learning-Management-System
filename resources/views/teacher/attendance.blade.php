@extends('layouts.teacher.app')
@section('page_title', 'Attendance')

@section('content')
@php
    $presentCount = $attendanceRecords->where('status', 'present')->count();
    $absentCount = $attendanceRecords->where('status', 'absent')->count();
    $lateCount = $attendanceRecords->where('status', 'late')->count();
@endphp

<style>
    .teacher-page-card {
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        box-shadow: 0 8px 24px rgba(15, 23, 42, 0.04);
        overflow: hidden;
    }
    .teacher-page-card .card-header {
        background: #fff;
        border-bottom: 1px solid #e2e8f0;
    }
    .teacher-page-card .table thead th {
        font-size: .78rem;
        text-transform: uppercase;
        letter-spacing: .04em;
        color: #64748b;
        background: #f8fafc;
    }
</style>

<div class="container-fluid p-1 p-lg-2">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4" style="background: linear-gradient(120deg, #0f172a 0%, #059669 58%, #14b8a6 100%);">
                <div class="card-body text-white p-4 p-lg-5">
                    <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3">
                        <div>
                            <h3 class="fw-bold mb-2"><i class="fas fa-calendar-check me-2"></i>Attendance</h3>
                            <p class="mb-0 opacity-75">Monitor class presence trends and follow up on absence patterns quickly.</p>
                        </div>
                        <div class="d-flex gap-2">
                            <span class="badge bg-success px-3 py-2">Present: {{ $presentCount }}</span>
                            <span class="badge bg-danger px-3 py-2">Absent: {{ $absentCount }}</span>
                            <span class="badge bg-warning text-dark px-3 py-2">Late: {{ $lateCount }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card teacher-page-card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold"><i class="fas fa-table-list me-2 text-primary"></i>Attendance Log</h5>
                    <a href="{{ route('teacher.dashboard') }}" class="btn btn-outline-secondary btn-sm">Back to Dashboard</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>Student</th>
                                    <th>Course</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Remarks</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($attendanceRecords as $record)
                                <tr>
                                    <td>{{ $record->student->user->name ?? 'N/A' }}</td>
                                    <td>{{ $record->course->title ?? 'N/A' }}</td>
                                    <td>{{ optional($record->date)->format('M d, Y') ?? 'N/A' }}</td>
                                    <td>
                                        @if($record->status === 'present')
                                            <span class="badge bg-success">Present</span>
                                        @elseif($record->status === 'absent')
                                            <span class="badge bg-danger">Absent</span>
                                        @else
                                            <span class="badge bg-warning text-dark">Late</span>
                                        @endif
                                    </td>
                                    <td>{{ $record->remarks ?? '-' }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">No attendance records found</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
