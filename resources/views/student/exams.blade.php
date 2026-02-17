@extends('layouts.student.app')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="page-title">Examinations</h2>
            <p class="text-muted">View your upcoming and past examinations</p>
        </div>
    </div>

    <!-- Exams List -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Exam Schedule</h5>
                </div>
                <div class="card-body">
                    @if($exams->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Exam Title</th>
                                        <th>Course</th>
                                        <th>Date</th>
                                        <th>Time</th>
                                        <th>Total Marks</th>
                                        <th>Type</th>
                                        <th>Status</th>
                                        <th>Result</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($exams as $exam)
                                        <tr>
                                            <td>
                                                <strong>{{ $exam->title }}</strong>
                                                @if($exam->description)
                                                    <br><small class="text-muted">{{ Str::limit($exam->description, 50) }}</small>
                                                @endif
                                            </td>
                                            <td>{{ $exam->course->title ?? 'N/A' }}</td>
                                            <td>{{ $exam->exam_date->format('M d, Y') }}</td>
                                            <td>{{ date('h:i A', strtotime($exam->start_time)) }} - {{ date('h:i A', strtotime($exam->end_time)) }}</td>
                                            <td>{{ $exam->total_marks }}</td>
                                            <td>
                                                <span class="badge bg-info">{{ ucfirst($exam->type) }}</span>
                                            </td>
                                            <td>
                                                @if($exam->status == 'scheduled')
                                                    <span class="badge bg-primary">Scheduled</span>
                                                @elseif($exam->status == 'ongoing')
                                                    <span class="badge bg-warning">Ongoing</span>
                                                @elseif($exam->status == 'completed')
                                                    <span class="badge bg-success">Completed</span>
                                                @else
                                                    <span class="badge bg-danger">Cancelled</span>
                                                @endif
                                            </td>
                                            <td>
                                                @php
                                                    $gradeScore = $exam->gradeScores->first();
                                                @endphp
                                                @if($gradeScore)
                                                    <strong>{{ $gradeScore->marks_obtained }}/{{ $gradeScore->total_marks }}</strong>
                                                    <br><span class="badge bg-success">{{ $gradeScore->grade }}</span>
                                                @else
                                                    <span class="text-muted">Not graded</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-clipboard-list fa-3x text-muted mb-3"></i>
                            <p class="text-muted">No exams scheduled yet.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Exam Statistics -->
    <div class="row mt-4">
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h3 class="text-primary">{{ $exams->where('status', 'scheduled')->count() }}</h3>
                    <p class="text-muted mb-0">Upcoming Exams</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h3 class="text-success">{{ $exams->where('status', 'completed')->count() }}</h3>
                    <p class="text-muted mb-0">Completed Exams</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    @php
                        $avgScore = $exams->flatMap->gradeScores->avg('percentage');
                    @endphp
                    <h3 class="text-info">{{ $avgScore ? number_format($avgScore, 1) : '0' }}%</h3>
                    <p class="text-muted mb-0">Average Score</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h3 class="text-warning">{{ $exams->count() }}</h3>
                    <p class="text-muted mb-0">Total Exams</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
