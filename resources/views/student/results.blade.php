@extends('layouts.student.app')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container-fluid p-4">
    <!-- Stats -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <h2 class="text-primary">{{ number_format($averagePercentage, 1) }}%</h2>
                    <p class="text-muted mb-0">Average Percentage</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <h2 class="text-success">{{ $totalSubjects }}</h2>
                    <p class="text-muted mb-0">Total Subjects</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <h2 class="text-info">{{ $grades->count() }}</h2>
                    <p class="text-muted mb-0">Total Grades</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Grades Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white">
            <h5 class="mb-0">Grade Report</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Course</th>
                            <th>Type</th>
                            <th>Marks Obtained</th>
                            <th>Total Marks</th>
                            <th>Percentage</th>
                            <th>Grade</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($grades as $grade)
                            <tr>
                                <td>{{ $grade->course->title ?? 'N/A' }}</td>
                                <td>
                                    @if($grade->assignment_id)
                                        <span class="badge bg-primary">Assignment</span>
                                    @elseif($grade->exam_id)
                                        <span class="badge bg-warning text-dark">Exam</span>
                                    @else
                                        <span class="badge bg-secondary">Other</span>
                                    @endif
                                </td>
                                <td>{{ $grade->marks_obtained }}</td>
                                <td>{{ $grade->total_marks }}</td>
                                <td><strong>{{ number_format($grade->percentage, 1) }}%</strong></td>
                                <td><span class="badge bg-success">{{ $grade->grade }}</span></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">No grades available</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
