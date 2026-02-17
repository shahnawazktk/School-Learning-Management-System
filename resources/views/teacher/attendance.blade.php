@extends('layouts.teacher.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h2><i class="fas fa-calendar-check"></i> Attendance</h2>
            <p class="text-muted">Track student attendance</p>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
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
                                    <td>{{ $record->course->name ?? 'N/A' }}</td>
                                    <td>{{ $record->date->format('M d, Y') }}</td>
                                    <td>
                                        @if($record->status === 'present')
                                            <span class="badge bg-success">Present</span>
                                        @elseif($record->status === 'absent')
                                            <span class="badge bg-danger">Absent</span>
                                        @else
                                            <span class="badge bg-warning">Late</span>
                                        @endif
                                    </td>
                                    <td>{{ $record->remarks ?? '-' }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center">No attendance records found</td>
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

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
@endsection
