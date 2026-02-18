@extends('layouts.teacher.app')
@section('page_title', 'Exams')

@section('content')
@php
    $upcomingExams = $exams->filter(fn ($exam) => $exam->exam_date && $exam->exam_date->isFuture())->count();
    $completedExams = $exams->count() - $upcomingExams;
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
            <div class="card border-0 shadow-sm rounded-4" style="background: linear-gradient(120deg, #0f172a 0%, #6d28d9 58%, #7c3aed 100%);">
                <div class="card-body text-white p-4 p-lg-5">
                    <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3">
                        <div>
                            <h3 class="fw-bold mb-2"><i class="fas fa-clipboard-list me-2"></i>Exams</h3>
                            <p class="mb-0 opacity-75">Manage exam schedule, marks allocation, and completion status by course.</p>
                        </div>
                        <div class="d-flex gap-2">
                            <span class="badge bg-light text-dark px-3 py-2">Total: {{ $exams->count() }}</span>
                            <span class="badge bg-primary px-3 py-2">Upcoming: {{ $upcomingExams }}</span>
                            <span class="badge bg-secondary px-3 py-2">Completed: {{ $completedExams }}</span>
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
                    <h5 class="mb-0 fw-bold"><i class="fas fa-table-list me-2 text-primary"></i>Exam Schedule</h5>
                    <a href="{{ route('teacher.dashboard') }}" class="btn btn-outline-secondary btn-sm">Back to Dashboard</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>Exam</th>
                                    <th>Course</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Total Marks</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($exams as $exam)
                                <tr>
                                    <td><strong>{{ $exam->title }}</strong></td>
                                    <td>{{ $exam->course->title ?? 'N/A' }}</td>
                                    <td>{{ optional($exam->exam_date)->format('M d, Y') ?? 'N/A' }}</td>
                                    <td>
                                        @if($exam->start_time && $exam->end_time)
                                            {{ \Illuminate\Support\Carbon::parse($exam->start_time)->format('h:i A') }} - {{ \Illuminate\Support\Carbon::parse($exam->end_time)->format('h:i A') }}
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td>{{ $exam->total_marks }}</td>
                                    <td>
                                        @if($exam->exam_date && $exam->exam_date->isPast())
                                            <span class="badge bg-secondary">Completed</span>
                                        @else
                                            <span class="badge bg-primary">Upcoming</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-muted">No exams scheduled</td>
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
