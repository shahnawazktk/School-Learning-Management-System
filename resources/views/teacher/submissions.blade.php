@extends('layouts.teacher.app')
@section('page_title', 'Submissions')

@section('content')
@php
    $gradedCount = $submissions->where('status', 'graded')->count();
    $pendingCount = $submissions->where('status', '!=', 'graded')->count();
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
            <div class="card border-0 shadow-sm rounded-4" style="background: linear-gradient(120deg, #0f172a 0%, #dc2626 58%, #f97316 100%);">
                <div class="card-body text-white p-4 p-lg-5">
                    <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3">
                        <div>
                            <h3 class="fw-bold mb-2"><i class="fas fa-file-lines me-2"></i>Student Submissions</h3>
                            <p class="mb-0 opacity-75">Review incoming work, monitor pending checks, and keep grading on schedule.</p>
                        </div>
                        <div class="d-flex gap-2">
                            <span class="badge bg-light text-dark px-3 py-2">Total: {{ $submissions->count() }}</span>
                            <span class="badge bg-warning text-dark px-3 py-2">Pending: {{ $pendingCount }}</span>
                            <span class="badge bg-success px-3 py-2">Graded: {{ $gradedCount }}</span>
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
                    <h5 class="mb-0 fw-bold"><i class="fas fa-clipboard-check me-2 text-primary"></i>Submission Queue</h5>
                    <a href="{{ route('teacher.dashboard') }}" class="btn btn-outline-secondary btn-sm">Back to Dashboard</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>Student</th>
                                    <th>Assignment</th>
                                    <th>Course</th>
                                    <th>Submitted</th>
                                    <th>Marks</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($submissions as $submission)
                                <tr>
                                    <td>{{ $submission->student->user->name ?? 'N/A' }}</td>
                                    <td>{{ $submission->assignment->title ?? 'N/A' }}</td>
                                    <td>{{ $submission->assignment->course->title ?? 'N/A' }}</td>
                                    <td>{{ optional($submission->submitted_at)->format('M d, Y h:i A') ?? 'N/A' }}</td>
                                    <td>{{ $submission->marks_obtained ?? '-' }} / {{ $submission->assignment->max_marks ?? '-' }}</td>
                                    <td>
                                        @if($submission->status === 'graded')
                                            <span class="badge bg-success">Graded</span>
                                        @else
                                            <span class="badge bg-warning text-dark">Pending</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-muted">No submissions found</td>
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
