<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Result Card</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f1f5f9;
        }

        .result-sheet {
            max-width: 980px;
            margin: 24px auto;
            border: 0;
            border-radius: 14px;
            overflow: hidden;
        }

        .sheet-head {
            background: linear-gradient(120deg, #0f766e 0%, #0369a1 100%);
            color: #fff;
        }

        .stat-box {
            border-radius: 10px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
        }

        @media print {
            body {
                background: #fff !important;
            }

            .no-print {
                display: none !important;
            }

            .result-sheet {
                margin: 0;
                max-width: 100%;
                box-shadow: none !important;
            }
        }
    </style>
</head>
<body>
    <div class="container py-3 no-print">
        <div class="d-flex flex-wrap gap-2 justify-content-between align-items-center">
            <a href="{{ route('student.results', request()->query()) }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i> Back to Results
            </a>
            <div class="d-flex gap-2">
                <a href="{{ route('student.results.card.download', request()->query()) }}" class="btn btn-primary">
                    <i class="fas fa-download me-1"></i> Download Result Card (PDF)
                </a>
                <button class="btn btn-dark" onclick="window.print()">
                    <i class="fas fa-print me-1"></i> Print / Save PDF
                </button>
            </div>
        </div>
    </div>

    <div class="card shadow-sm result-sheet">
        <div class="card-body p-0">
            <div class="sheet-head p-4 p-md-5">
                <div class="row g-3 align-items-center">
                    <div class="col-md-8">
                        <h3 class="mb-1 fw-bold">Official Result Card</h3>
                        <p class="mb-0 opacity-75">Academic performance summary and assessment details</p>
                    </div>
                    <div class="col-md-4 text-md-end">
                        <div class="small opacity-75">Generated On</div>
                        <div class="fw-semibold">{{ now()->format('M d, Y h:i A') }}</div>
                    </div>
                </div>
            </div>

            <div class="p-4 p-md-5">
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <div class="stat-box p-3 h-100">
                            <div class="small text-muted">Student Name</div>
                            <div class="fw-semibold">{{ auth()->user()->name }}</div>
                            <div class="small text-muted mt-2">Student ID</div>
                            <div class="fw-semibold">{{ $student->student_id ?? ('STU-' . $student->id) }}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="stat-box p-3 h-100">
                            <div class="small text-muted">Average Percentage</div>
                            <div class="fw-semibold">{{ number_format($averagePercentage, 1) }}%</div>
                            <div class="small text-muted mt-2">Pass Rate</div>
                            <div class="fw-semibold">{{ number_format($passRate, 1) }}%</div>
                        </div>
                    </div>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-6 col-md-3">
                        <div class="stat-box p-3 text-center">
                            <div class="small text-muted">Subjects</div>
                            <div class="h5 mb-0">{{ $totalSubjects }}</div>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="stat-box p-3 text-center">
                            <div class="small text-muted">Records</div>
                            <div class="h5 mb-0">{{ $grades->count() }}</div>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="stat-box p-3 text-center">
                            <div class="small text-muted">Highest</div>
                            <div class="h5 mb-0">{{ number_format($highestPercentage, 1) }}%</div>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="stat-box p-3 text-center">
                            <div class="small text-muted">Lowest</div>
                            <div class="h5 mb-0">{{ number_format($lowestPercentage, 1) }}%</div>
                        </div>
                    </div>
                </div>

                <h5 class="mb-3">Assessment Breakdown</h5>
                <div class="table-responsive">
                    <table class="table table-bordered align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Course</th>
                                <th>Assessment</th>
                                <th class="text-center">Marks</th>
                                <th class="text-center">Percentage</th>
                                <th class="text-center">Grade</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($grades as $grade)
                                <tr>
                                    <td>{{ $grade->course->title ?? 'N/A' }}</td>
                                    <td>{{ $grade->assignment->title ?? $grade->exam->title ?? 'General Assessment' }}</td>
                                    <td class="text-center">{{ $grade->marks_obtained }} / {{ $grade->total_marks }}</td>
                                    <td class="text-center">{{ number_format($grade->percentage, 1) }}%</td>
                                    <td class="text-center fw-semibold">{{ $grade->grade }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted">No records found for selected filters.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
