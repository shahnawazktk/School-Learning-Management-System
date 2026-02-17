@extends('layouts.student.app')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container-fluid p-4">
    <!-- Stats -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <h2 class="text-primary">{{ $attendancePercentage }}%</h2>
                    <p class="text-muted mb-0">Overall Attendance</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <h2 class="text-success">{{ $attendanceRecords->where('status', 'present')->count() }}</h2>
                    <p class="text-muted mb-0">Present Days</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <h2 class="text-danger">{{ $attendanceRecords->where('status', 'absent')->count() }}</h2>
                    <p class="text-muted mb-0">Absent Days</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Attendance Records -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white">
            <h5 class="mb-0">Attendance Records</h5>
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
        </div>
    </div>
</div>
@endsection
