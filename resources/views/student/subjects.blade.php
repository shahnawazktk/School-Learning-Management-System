@extends('layouts.student.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">
                            <i class="fas fa-book-open text-primary"></i> My Subjects
                        </h4>
                        <div class="card-tools">
                            <select class="form-select form-select-sm" id="subjectFilter">
                                <option value="all">All Subjects</option>
                                <option value="active">Active Only</option>
                                <option value="completed">Completed</option>
                            </select>
                        </div>
                    </div>
                    <div class="card-body">
                        @if ($enrollments->count() > 0)
                            <div class="row" id="subjectsContainer">
                                @foreach ($enrollments as $enrollment)
                                    <div class="col-lg-4 col-md-6 mb-4 subject-card"
                                        data-status="{{ $enrollment->status }}">
                                        <div class="card h-100 border-left-primary">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center mb-3">
                                                    <div class="subject-icon mr-3">
                                                        <i class="fas fa-book text-primary"></i>
                                                    </div>
                                                    <div>
                                                        <h6 class="card-title mb-1">
                                                            {{ $enrollment->course->name ?? $enrollment->subject->name }}
                                                        </h6>
                                                        <small
                                                            class="text-muted">{{ $enrollment->course->code ?? $enrollment->subject->code }}</small>
                                                    </div>
                                                </div>

                                                @if ($enrollment->course && $enrollment->course->teacher)
                                                    <div class="teacher-info mb-3">
                                                        <small class="text-muted d-block">Teacher</small>
                                                        <div class="d-flex align-items-center">
                                                            <div class="avatar-sm mr-2">
                                                                <span class="avatar-title bg-info rounded-circle">
                                                                    {{ substr($enrollment->course->teacher->name, 0, 1) }}
                                                                </span>
                                                            </div>
                                                            <span
                                                                class="font-weight-medium">{{ $enrollment->course->teacher->name }}</span>
                                                        </div>
                                                    </div>
                                                @endif

                                                <div class="subject-stats mb-3">
                                                    <div class="row text-center">
                                                        <div class="col-4">
                                                            <div class="stat-item">
                                                                <span
                                                                    class="stat-value">{{ $enrollment->attendance_percentage ?? 0 }}%</span>
                                                                <small class="text-muted">Attendance</small>
                                                            </div>
                                                        </div>
                                                        <div class="col-4">
                                                            <div class="stat-item">
                                                                <span
                                                                    class="stat-value">{{ $enrollment->assignments_completed ?? 0 }}</span>
                                                                <small class="text-muted">Assignments</small>
                                                            </div>
                                                        </div>
                                                        <div class="col-4">
                                                            <div class="stat-item">
                                                                <span
                                                                    class="stat-value">{{ $enrollment->average_grade ?? 'N/A' }}</span>
                                                                <small class="text-muted">Grade</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="card-actions">
                                                    <a href="{{ route('student.assignments') }}?subject={{ $enrollment->course_id ?? $enrollment->subject_id }}"
                                                        class="btn btn-outline-primary btn-sm">
                                                        <i class="fas fa-tasks"></i> Assignments
                                                    </a>
                                                    <a href="{{ route('student.resources') }}?subject={{ $enrollment->course_id ?? $enrollment->subject_id }}"
                                                        class="btn btn-outline-info btn-sm">
                                                        <i class="fas fa-file-alt"></i> Resources
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="fas fa-book-open fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">No Subjects Enrolled</h5>
                                <p class="text-muted">You are not enrolled in any subjects yet.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
        <style>
            .subject-icon {
                width: 40px;
                height: 40px;
                border-radius: 50%;
                background-color: #e3f2fd;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .avatar-sm {
                width: 30px;
                height: 30px;
            }

            .avatar-title {
                width: 100%;
                height: 100%;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 0.8rem;
                font-weight: bold;
            }

            .stat-item .stat-value {
                font-size: 1.2rem;
                font-weight: bold;
                color: #495057;
                display: block;
            }

            .card-actions {
                display: flex;
                gap: 0.5rem;
                justify-content: center;
            }

            .border-left-primary {
                border-left: 4px solid #007bff !important;
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            $(document).ready(function() {
                $('#subjectFilter').on('change', function() {
                    const filter = $(this).val();
                    const cards = $('.subject-card');

                    if (filter === 'all') {
                        cards.show();
                    } else {
                        cards.each(function() {
                            const status = $(this).data('status');
                            if (status === filter) {
                                $(this).show();
                            } else {
                                $(this).hide();
                            }
                        });
                    }
                });
            });
        </script>
    @endpush
@endsection
