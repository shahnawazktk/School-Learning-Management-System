@extends('layouts.student.app')

@section('content')
    <div class="container-fluid">
        <!-- Results Statistics -->
        <div class="row mb-4">
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card">
                    <div class="card-body text-center">
                        <div class="avatar mx-auto mb-3"
                            style="width: 60px; height: 60px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-star fa-2x text-white"></i>
                        </div>
                        <h4 class="mb-1">{{ number_format($averagePercentage, 1) }}%</h4>
                        <p class="text-muted mb-0">Average Percentage</p>
                        <small class="text-success">
                            <i class="fas fa-arrow-up"></i> Excellent
                        </small>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card">
                    <div class="card-body text-center">
                        <div class="avatar mx-auto mb-3"
                            style="width: 60px; height: 60px; background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-book fa-2x text-white"></i>
                        </div>
                        <h4 class="mb-1">{{ $totalSubjects }}</h4>
                        <p class="text-muted mb-0">Total Subjects</p>
                        <small class="text-muted">This semester</small>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card">
                    <div class="card-body text-center">
                        <div class="avatar mx-auto mb-3"
                            style="width: 60px; height: 60px; background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-medal fa-2x text-white"></i>
                        </div>
                        <h4 class="mb-1">{{ $gradeDistribution['A+'] + $gradeDistribution['A'] }}</h4>
                        <p class="text-muted mb-0">A Grades</p>
                        <small class="text-success">High achiever</small>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card">
                    <div class="card-body text-center">
                        <div class="avatar mx-auto mb-3"
                            style="width: 60px; height: 60px; background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-chart-pie fa-2x text-white"></i>
                        </div>
                        <h4 class="mb-1">{{ $grades->count() }}</h4>
                        <p class="text-muted mb-0">Total Assessments</p>
                        <small class="text-muted">Completed</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Grade Distribution Chart -->
        <div class="row mb-4">
            <div class="col-lg-8 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-chart-bar text-primary"></i> Subject-wise Performance
                        </h5>
                    </div>
                    <div class="card-body">
                        <canvas id="resultsChart" height="300"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-graduation-cap text-primary"></i> Grade Distribution
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="grade-legend">
                            <div class="grade-item">
                                <span class="grade-color" style="background-color: #28a745;"></span>
                                <span class="grade-label">A+ (95-100%)</span>
                                <span class="grade-count">{{ $gradeDistribution['A+'] ?? 0 }}</span>
                            </div>
                            <div class="grade-item">
                                <span class="grade-color" style="background-color: #20c997;"></span>
                                <span class="grade-label">A (90-94%)</span>
                                <span class="grade-count">{{ $gradeDistribution['A'] ?? 0 }}</span>
                            </div>
                            <div class="grade-item">
                                <span class="grade-color" style="background-color: #007bff;"></span>
                                <span class="grade-label">B+ (80-89%)</span>
                                <span class="grade-count">{{ $gradeDistribution['B+'] ?? 0 }}</span>
                            </div>
                            <div class="grade-item">
                                <span class="grade-color" style="background-color: #6c757d;"></span>
                                <span class="grade-label">B (70-79%)</span>
                                <span class="grade-count">{{ $gradeDistribution['B'] ?? 0 }}</span>
                            </div>
                            <div class="grade-item">
                                <span class="grade-color" style="background-color: #ffc107;"></span>
                                <span class="grade-label">C+ (65-69%)</span>
                                <span class="grade-count">{{ $gradeDistribution['C+'] ?? 0 }}</span>
                            </div>
                            <div class="grade-item">
                                <span class="grade-color" style="background-color: #fd7e14;"></span>
                                <span class="grade-label">C (60-64%)</span>
                                <span class="grade-count">{{ $gradeDistribution['C'] ?? 0 }}</span>
                            </div>
                            <div class="grade-item">
                                <span class="grade-color" style="background-color: #dc3545;"></span>
                                <span class="grade-label">D (50-59%)</span>
                                <span class="grade-count">{{ $gradeDistribution['D'] ?? 0 }}</span>
                            </div>
                            <div class="grade-item">
                                <span class="grade-color" style="background-color: #6f42c1;"></span>
                                <span class="grade-label">F (Below 50%)</span>
                                <span class="grade-count">{{ $gradeDistribution['F'] ?? 0 }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detailed Results Table -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-table text-primary"></i> Detailed Results
                        </h5>
                        <div class="card-tools">
                            <select class="form-select form-select-sm" id="termFilter">
                                <option value="all">All Terms</option>
                                <option value="term1">Term 1</option>
                                <option value="term2" selected>Term 2</option>
                                <option value="term3">Term 3</option>
                                <option value="final">Final Exam</option>
                            </select>
                            <button class="btn btn-outline-secondary btn-sm">
                                <i class="fas fa-download"></i> Export
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        @if ($grades->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Subject</th>
                                            <th>Assessment</th>
                                            <th>Marks Obtained</th>
                                            <th>Total Marks</th>
                                            <th>Percentage</th>
                                            <th>Grade</th>
                                            <th>Date</th>
                                            <th>Remarks</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($grades as $grade)
                                            <tr>
                                                <td>
                                                    <strong>{{ $grade->course->name ?? 'N/A' }}</strong>
                                                </td>
                                                <td>{{ $grade->assignment->title ?? 'Exam' }}</td>
                                                <td>{{ $grade->marks }}</td>
                                                <td>{{ $grade->max_marks }}</td>
                                                <td>
                                                    <strong>{{ number_format($grade->percentage, 1) }}%</strong>
                                                </td>
                                                <td>
                                                    <span class="grade-badge grade-{{ strtolower($grade->grade) }}">
                                                        {{ $grade->grade }}
                                                    </span>
                                                </td>
                                                <td>{{ $grade->created_at->format('M d, Y') }}</td>
                                                <td>
                                                    <small class="text-muted">{{ $grade->remarks ?? '-' }}</small>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="fas fa-chart-line fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">No Results Available</h5>
                                <p class="text-muted">Your exam results and grades will appear here once they are
                                    published.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
        <style>
            .avatar {
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .table th {
                border-top: none;
                font-weight: 600;
                color: #495057;
            }

            .table-hover tbody tr:hover {
                background-color: #f8f9fa;
            }

            .grade-legend {
                display: flex;
                flex-direction: column;
                gap: 0.75rem;
            }

            .grade-item {
                display: flex;
                align-items: center;
                justify-content: space-between;
                padding: 0.5rem 0;
                border-bottom: 1px solid #f1f5f9;
            }

            .grade-item:last-child {
                border-bottom: none;
            }

            .grade-color {
                width: 16px;
                height: 16px;
                border-radius: 50%;
                margin-right: 0.75rem;
                flex-shrink: 0;
            }

            .grade-label {
                flex: 1;
                font-size: 0.9rem;
                color: #495057;
            }

            .grade-count {
                font-weight: 600;
                color: #495057;
                background-color: #f8f9fa;
                padding: 0.25rem 0.5rem;
                border-radius: 12px;
                font-size: 0.8rem;
                min-width: 24px;
                text-align: center;
            }

            .grade-badge {
                padding: 0.4rem 0.8rem;
                border-radius: 20px;
                font-size: 0.8rem;
                font-weight: 600;
                color: white;
            }

            .grade-a,
            .grade-a+ {
                background-color: #28a745;
            }

            .grade-b,
            .grade-b+ {
                background-color: #007bff;
            }

            .grade-c,
            .grade-c+ {
                background-color: #ffc107;
                color: #212529;
            }

            .grade-d {
                background-color: #fd7e14;
            }

            .grade-f {
                background-color: #dc3545;
            }
        </style>
    @endpush

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            $(document).ready(function() {
                // Initialize results chart
                const ctx = document.getElementById('resultsChart').getContext('2d');
                const resultsChart = new Chart(ctx, {
                    type: 'radar',
                    data: {
                        labels: @json($grades->pluck('course.name')->unique()->values()),
                        datasets: [{
                            label: 'Your Scores (%)',
                            data: @json($grades->pluck('percentage')->values()),
                            backgroundColor: 'rgba(59, 130, 246, 0.2)',
                            borderColor: '#3b82f6',
                            borderWidth: 2,
                            pointBackgroundColor: '#3b82f6',
                            pointBorderColor: '#fff',
                            pointBorderWidth: 2,
                            pointRadius: 6,
                            pointHoverRadius: 8
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            }
                        },
                        scales: {
                            r: {
                                angleLines: {
                                    display: true
                                },
                                suggestedMin: 0,
                                suggestedMax: 100,
                                ticks: {
                                    callback: function(value) {
                                        return value + '%';
                                    }
                                },
                                grid: {
                                    color: 'rgba(0,0,0,0.1)'
                                }
                            }
                        },
                        elements: {
                            point: {
                                hoverBorderWidth: 3
                            }
                        }
                    }
                });

                // Term filter
                $('#termFilter').on('change', function() {
                    const term = $(this).val();
                    // In a real application, you would make an AJAX call to filter the data
                    // For now, we'll just show a notification
                    toastr.info(`Filtering by ${term} - This feature would filter the results by term.`);
                });
            });
        </script>
    @endpush
@endsection
