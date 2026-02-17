@extends('layouts.teacher.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h2><i class="fas fa-tasks"></i> Assignments</h2>
            <p class="text-muted">Manage and track all assignments</p>
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
                                    <td>{{ $assignment->course->name ?? 'N/A' }}</td>
                                    <td>{{ $assignment->due_date->format('M d, Y') }}</td>
                                    <td>{{ $assignment->max_marks }}</td>
                                    <td>{{ $assignment->submissions->count() }}</td>
                                    <td>
                                        @if($assignment->due_date->isPast())
                                            <span class="badge bg-secondary">Closed</span>
                                        @else
                                            <span class="badge bg-success">Active</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center">No assignments found</td>
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
