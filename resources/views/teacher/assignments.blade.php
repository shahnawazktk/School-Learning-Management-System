@extends('layouts.teacher.app')
@section('page_title', 'Assignments')

@section('content')
@php
    $activeAssignments = $assignments->filter(fn ($assignment) => $assignment->due_date && $assignment->due_date->isFuture())->count();
    $closedAssignments = $assignments->count() - $activeAssignments;
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
            <div class="card border-0 shadow-sm rounded-4" style="background: linear-gradient(120deg, #0f172a 0%, #2563eb 58%, #0ea5e9 100%);">
                <div class="card-body text-white p-4 p-lg-5">
                    <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3">
                        <div>
                            <h3 class="fw-bold mb-2"><i class="fas fa-list-check me-2"></i>Assignments</h3>
                            <p class="mb-0 opacity-75">Track deadlines, submission load, and course-level assignment activity.</p>
                        </div>
                        <div class="d-flex gap-2">
                            <span class="badge bg-light text-dark px-3 py-2">Total: {{ $assignments->count() }}</span>
                            <span class="badge bg-success px-3 py-2">Active: {{ $activeAssignments }}</span>
                            <span class="badge bg-secondary px-3 py-2">Closed: {{ $closedAssignments }}</span>
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
                    <h5 class="mb-0 fw-bold"><i class="fas fa-table-list me-2 text-primary"></i>Assignment Register</h5>
                    <a href="{{ route('teacher.dashboard') }}" class="btn btn-outline-secondary btn-sm">Back to Dashboard</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Course</th>
                                    <th>Due Date</th>
                                    <th>Max Marks</th>
                                    <th>Submissions</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($assignments as $assignment)
                                <tr>
                                    <td><strong>{{ $assignment->title }}</strong></td>
                                    <td>{{ $assignment->course->title ?? 'N/A' }}</td>
                                    <td>{{ optional($assignment->due_date)->format('M d, Y') ?? 'N/A' }}</td>
                                    <td>{{ $assignment->max_marks }}</td>
                                    <td><span class="badge text-bg-light">{{ $assignment->submissions->count() }}</span></td>
                                    <td>
                                        @if($assignment->due_date && $assignment->due_date->isPast())
                                            <span class="badge bg-secondary">Closed</span>
                                        @else
                                            <span class="badge bg-success">Active</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-muted">No assignments found</td>
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
