@extends('layouts.teacher.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h2><i class="fas fa-clipboard-list"></i> Exams</h2>
            <p class="text-muted">Manage exams and results</p>
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
                                    <th>Exam Name</th>
                                    <th>Course</th>
                                    <th>Date</th>
                                    <th>Duration</th>
                                    <th>Total Marks</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($exams as $exam)
                                <tr>
                                    <td><strong>{{ $exam->name }}</strong></td>
                                    <td>{{ $exam->course->name ?? 'N/A' }}</td>
                                    <td>{{ $exam->exam_date->format('M d, Y') }}</td>
                                    <td>{{ $exam->duration }} min</td>
                                    <td>{{ $exam->total_marks }}</td>
                                    <td>
                                        @if($exam->exam_date->isPast())
                                            <span class="badge bg-secondary">Completed</span>
                                        @else
                                            <span class="badge bg-primary">Upcoming</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center">No exams scheduled</td>
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
