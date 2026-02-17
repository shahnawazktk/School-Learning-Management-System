<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exam Admit Card</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f1f5f9;
        }

        .card-shell {
            max-width: 860px;
            margin: 24px auto;
            border: 0;
            border-radius: 14px;
            overflow: hidden;
        }

        .card-head {
            background: linear-gradient(120deg, #0f766e 0%, #075985 100%);
            color: #fff;
        }

        .info-box {
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 14px;
            background: #f8fafc;
        }

        @media print {
            .no-print {
                display: none !important;
            }

            body {
                background: #fff !important;
            }

            .card-shell {
                margin: 0;
                max-width: 100%;
                box-shadow: none !important;
            }
        }
    </style>
</head>
<body>
    <div class="container py-3 no-print">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
            <a href="{{ route('student.exams', request()->query()) }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i> Back to Exams
            </a>
            <div class="d-flex gap-2">
                <a href="{{ route('student.exams.admit-card.download', $exam->id) }}" class="btn btn-primary">
                    <i class="fas fa-download me-1"></i> Download PDF
                </a>
                <button type="button" class="btn btn-dark" onclick="window.print()">
                    <i class="fas fa-print me-1"></i> Print
                </button>
            </div>
        </div>
    </div>

    <div class="card shadow-sm card-shell">
        <div class="card-body p-0">
            <div class="card-head p-4 p-md-5">
                <div class="d-flex justify-content-between flex-wrap gap-2 align-items-center">
                    <div>
                        <h3 class="mb-1 fw-bold">Exam Admit Card</h3>
                        <p class="mb-0 opacity-75">Present this card before examination entry</p>
                    </div>
                    <div class="text-md-end">
                        <div class="small opacity-75">Card ID</div>
                        <div class="fw-semibold">EXAM-{{ $exam->id }}-STU-{{ $student->id }}</div>
                    </div>
                </div>
            </div>

            <div class="p-4 p-md-5">
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <div class="info-box h-100">
                            <div class="small text-muted">Student Name</div>
                            <div class="fw-semibold">{{ auth()->user()->name }}</div>
                            <div class="small text-muted mt-2">Student ID</div>
                            <div class="fw-semibold">{{ $student->student_id ?? ('STU-' . $student->id) }}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-box h-100">
                            <div class="small text-muted">Course</div>
                            <div class="fw-semibold">{{ $exam->course->title ?? 'N/A' }}</div>
                            <div class="small text-muted mt-2">Exam Type</div>
                            <div class="fw-semibold">{{ ucfirst($exam->type ?? 'General') }}</div>
                        </div>
                    </div>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <div class="info-box text-center h-100">
                            <div class="small text-muted">Exam Date</div>
                            <div class="h5 mb-0">{{ optional($exam->exam_date)->format('M d, Y') ?? 'N/A' }}</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="info-box text-center h-100">
                            <div class="small text-muted">Exam Time</div>
                            <div class="h5 mb-0">
                                {{ $exam->start_time ? date('h:i A', strtotime($exam->start_time)) : 'TBD' }}
                                -
                                {{ $exam->end_time ? date('h:i A', strtotime($exam->end_time)) : 'TBD' }}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="info-box text-center h-100">
                            <div class="small text-muted">Total Marks</div>
                            <div class="h5 mb-0">{{ $exam->total_marks ?? 'N/A' }}</div>
                        </div>
                    </div>
                </div>

                <div class="alert alert-light border mb-4">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <div>
                            <strong>Status:</strong>
                            <span class="badge text-bg-primary">{{ ucfirst($exam->status ?? 'Scheduled') }}</span>
                        </div>
                        @if($gradeScore)
                            <div>
                                <strong>Result:</strong>
                                <span class="badge text-bg-success">{{ $gradeScore->marks_obtained }}/{{ $gradeScore->total_marks }} | {{ $gradeScore->grade }}</span>
                            </div>
                        @else
                            <div class="text-muted small">Result will be published after exam evaluation.</div>
                        @endif
                    </div>
                </div>

                <h6 class="fw-bold mb-2">Exam Instructions</h6>
                <ul class="small text-muted mb-0">
                    <li>Reach exam venue at least 30 minutes before start time.</li>
                    <li>Carry this admit card and valid student ID card.</li>
                    <li>Follow all invigilator instructions during the exam.</li>
                </ul>
            </div>
        </div>
    </div>
</body>
</html>
