@extends('layouts.teacher.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h2><i class="fas fa-file-alt"></i> Student Submissions</h2>
            <p class="text-muted">Review and grade student submissions</p>
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
                                    <td>{{ $submission->assignment->course->name ?? 'N/A' }}</td>
                                    <td>{{ $submission->submitted_at->format('M d, Y') }}</td>
                                    <td>{{ $submission->marks_obtained ?? '-' }} / {{ $submission->assignment->max_marks }}</td>
                                    <td>
                                        @if($submission->status === 'graded')
                                            <span class="badge bg-success">Graded</span>
                                        @else
                                            <span class="badge bg-warning">Pending</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center">No submissions found</td>
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
