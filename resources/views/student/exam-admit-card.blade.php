<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exam Admit Card - {{ $exam->course->title ?? 'N/A' }}</title>
    <!-- Fonts and Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        :root {
            --primary: #1e3a8a;
            --secondary: #3b82f6;
            --accent: #f59e0b;
            --bg: #f3f4f6;
        }
        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg);
            color: #1e293b;
        }

        .admit-card-container {
            max-width: 900px;
            margin: 2rem auto;
            position: relative;
        }

        .admit-card {
            background: #fff;
            border-radius: 1.5rem;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            overflow: hidden;
            position: relative;
        }

        /* Decorative Header */
        .card-header-hero {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            padding: 3rem 2rem;
            color: white;
            position: relative;
            overflow: hidden;
        }
        .card-header-hero::before {
            content: '';
            position: absolute;
            top: -50%; right: -20%;
            width: 300px; height: 300px;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            border-radius: 50%;
        }
        .card-header-hero::after {
            content: '';
            position: absolute;
            bottom: -50%; left: -10%;
            width: 250px; height: 250px;
            background: radial-gradient(circle, rgba(0,0,0,0.1) 0%, transparent 70%);
            border-radius: 50%;
        }

        .institute-logo {
            width: 80px;
            height: 80px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            color: var(--primary);
            box-shadow: 0 10px 15px -3px rgba(0,0,0,0.2);
            z-index: 1;
            position: relative;
        }

        .badge-status {
            background: rgba(255,255,255,0.2);
            backdrop-filter: blur(4px);
            border: 1px solid rgba(255,255,255,0.3);
            color: white;
            padding: 0.5rem 1.25rem;
            border-radius: 50rem;
            font-weight: 600;
            letter-spacing: 0.05em;
        }

        /* Information Grid */
        .info-section {
            padding: 2.5rem;
        }

        .info-label {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #64748b;
            font-weight: 700;
            margin-bottom: 0.25rem;
        }

        .info-value {
            font-size: 1.1rem;
            font-weight: 600;
            color: #0f172a;
        }

        .info-box {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 1rem;
            padding: 1.25rem;
            height: 100%;
            transition: all 0.2s;
        }
        .info-box:hover {
            border-color: #cbd5e1;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
        }

        .student-photo-placeholder {
            width: 120px;
            height: 150px;
            background: #e2e8f0;
            border: 2px dashed #cbd5e1;
            border-radius: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #94a3b8;
            font-size: 3rem;
        }

        /* Editable Section */
        .editable-notes-section {
            background: #eff6ff;
            border: 1px solid #bfdbfe;
            border-radius: 1rem;
            padding: 1.5rem;
            margin-top: 2rem;
            position: relative;
        }
        
        .editable-field {
            min-height: 80px;
            padding: 1rem;
            background: white;
            border: 1px dashed #93c5fd;
            border-radius: 0.75rem;
            outline: none;
            transition: all 0.2s;
            color: #1e3a8a;
            font-weight: 500;
        }
        .editable-field:focus {
            border-color: var(--secondary);
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
        }
        .editable-field[data-placeholder]:empty:before {
            content: attr(data-placeholder);
            color: #94a3b8;
            pointer-events: none;
            display: block; /* For Firefox */
        }

        /* Print Styles */
        @media print {
            body { background: white !important; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
            .no-print { display: none !important; }
            .admit-card-container { margin: 0; max-width: 100%; }
            .admit-card { box-shadow: none; border-radius: 0; border: 1px solid #e2e8f0; }
            .editable-field { border: none !important; background: transparent !important; padding: 0 !important; }
            .card-header-hero { padding: 2rem; }
        }
    </style>
</head>
<body>
    
    <!-- Controls (No Print) -->
    <div class="container py-4 no-print position-relative z-3">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 bg-white p-3 rounded-4 shadow-sm">
            <a href="{{ route('student.exams', request()->query()) }}" class="btn btn-light rounded-pill fw-semibold px-4 border">
                <i class="fas fa-arrow-left me-2"></i> Back to Schedule
            </a>
            <div class="d-flex gap-2">
                <a href="{{ route('student.exams.admit-card.download', $exam->id) }}" class="btn btn-primary rounded-pill fw-semibold px-4 shadow-sm">
                    <i class="fas fa-download me-2"></i> Download Official PDF
                </a>
                <button type="button" class="btn btn-dark rounded-pill fw-semibold px-4 shadow-sm" onclick="window.print()">
                    <i class="fas fa-print me-2"></i> Print Card
                </button>
            </div>
        </div>
    </div>

    <!-- Main Card -->
    <div class="container admit-card-container pb-5">
        <div class="admit-card">
            
            <!-- Header -->
            <div class="card-header-hero position-relative z-1">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-4">
                    <div class="d-flex align-items-center gap-4">
                        <div class="institute-logo">
                            <i class="fas fa-university"></i>
                        </div>
                        <div>
                            <h2 class="fw-bold mb-1 text-white">Official Admit Card</h2>
                            <p class="mb-0 text-white-50 fs-5">Academic Examination Session</p>
                        </div>
                    </div>
                    <div class="text-md-end">
                        <span class="badge-status shadow-sm">
                            <i class="fas fa-barcode me-2"></i> EXAM-{{ $exam->id }}-STU-{{ $student->id }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Content Area -->
            <div class="info-section bg-white">
                
                <div class="row g-4 mb-4">
                    <!-- Photo (Placeholder for realistic feel) -->
                    <div class="col-12 col-md-auto d-flex justify-content-center justify-content-md-start">
                        <div class="student-photo-placeholder shadow-sm">
                            <i class="fas fa-user-graduate"></i>
                        </div>
                    </div>
                    
                    <!-- Core Details -->
                    <div class="col">
                        <div class="row g-3 h-100">
                            <div class="col-sm-6">
                                <div class="info-box">
                                    <div class="info-label">Candidate Name</div>
                                    <div class="info-value text-primary fs-4">{{ auth()->user()->name }}</div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="info-box">
                                    <div class="info-label">Student ID / Roll No.</div>
                                    <div class="info-value">{{ $student->student_id ?? ('STU-' . str_pad($student->id, 5, '0', STR_PAD_LEFT)) }}</div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="info-box">
                                    <div class="info-label">Course / Subject</div>
                                    <div class="info-value"><i class="fas fa-book me-2 text-muted"></i>{{ $exam->course->title ?? 'N/A' }}</div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="info-box">
                                    <div class="info-label">Examination Type</div>
                                    <div class="info-value"><i class="fas fa-tag me-2 text-muted"></i>{{ ucfirst($exam->type ?? 'General') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <hr class="border-secondary opacity-25 my-4">

                <!-- Schedule Grid -->
                <div class="row g-4 mb-4">
                    <div class="col-md-4">
                        <div class="info-box text-center bg-primary bg-opacity-10 border-primary border-opacity-25">
                            <div class="info-label text-primary">Exam Date</div>
                            <div class="info-value fs-4">{{ optional($exam->exam_date)->format('M d, Y') ?? 'N/A' }}</div>
                            <div class="small text-muted mt-1">{{ optional($exam->exam_date)->format('l') ?? '' }}</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="info-box text-center bg-primary bg-opacity-10 border-primary border-opacity-25">
                            <div class="info-label text-primary">Exam Time Window</div>
                            <div class="info-value fs-5 mt-1">
                                {{ $exam->start_time ? date('h:i A', strtotime($exam->start_time)) : 'TBD' }}
                                <br><span class="text-muted fs-6">to</span><br>
                                {{ $exam->end_time ? date('h:i A', strtotime($exam->end_time)) : 'TBD' }}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="info-box text-center bg-primary bg-opacity-10 border-primary border-opacity-25">
                            <div class="info-label text-primary">Assessment Details</div>
                            <div class="info-value fs-4 mt-1">{{ $exam->total_marks ?? 'N/A' }}</div>
                            <div class="small text-muted mt-1">Total Marks</div>
                        </div>
                    </div>
                </div>

                <!-- Result Status if Available -->
                @if($gradeScore)
                <div class="alert alert-success border-success bg-success bg-opacity-10 rounded-4 p-4 mb-4 d-flex align-items-center gap-4 shadow-sm">
                    <div class="bg-success text-white rounded-circle p-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                        <i class="fas fa-award fa-2x"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold text-success mb-1">Result Published</h5>
                        <p class="mb-0 fw-semibold text-dark fs-5">
                            Marks: {{ $gradeScore->marks_obtained }}/{{ $gradeScore->total_marks }} 
                            <span class="badge bg-success ms-2">{{ $gradeScore->grade }} ({{ number_format($gradeScore->percentage, 1) }}%)</span>
                        </p>
                    </div>
                </div>
                @endif

                <!-- Rules -->
                <div class="p-4 bg-light border rounded-4 mb-4">
                    <h5 class="fw-bold mb-3 text-dark"><i class="fas fa-list-ul me-2 text-primary"></i> Examination Directives</h5>
                    <ol class="mb-0 text-muted lh-lg">
                        <li>Candidates must occupy their assigned seats <strong>30 minutes</strong> before the commencement of the examination.</li>
                        <li>This Admit Card and a valid institutional ID are <strong>mandatory</strong> for entry into the examination hall.</li>
                        <li>Electronic gadgets, unauthorized materials, or communication devices are strictly prohibited.</li>
                        <li>Violation of examination rules may result in immediate disqualification and subsequent disciplinary action.</li>
                    </ol>
                </div>

                <!-- Interactive Personal Notes -->
                <div class="editable-notes-section shadow-sm no-print">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="fw-bold text-primary mb-0"><i class="fas fa-edit me-2"></i> My Personal Reminders (Editable)</h6>
                        <span class="badge bg-white text-muted border">Auto-saves to browser</span>
                    </div>
                    <div class="editable-field" 
                         contenteditable="true" 
                         id="admit_note_card_{{ auth()->id() }}_{{ $exam->id }}"
                         data-placeholder="Click here to type your personal notes, e.g., 'Bring scientific calculator', 'Revise chapter 5 formulas'... "></div>
                </div>

            </div>
            
            <!-- Footer -->
            <div class="bg-light p-4 text-center border-top">
                <p class="small text-muted mb-0">Document generated electronically by the LMS System on {{ now()->format('F d, Y h:i A') }}</p>
                <div class="mt-2 text-dark" style="font-family: monospace; letter-spacing: 2px;">
                    *{{ $exam->id }}00{{ $student->id }}*
                </div>
            </div>
            
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const field = document.getElementById('admit_note_card_{{ auth()->id() }}_{{ $exam->id }}');
            if(!field) return;

            const storageKey = field.id;
            const savedNote = localStorage.getItem(storageKey);

            if (savedNote) {
                field.textContent = savedNote;
            }

            field.addEventListener('blur', function() {
                const content = this.textContent.trim();
                const placeholder = this.getAttribute('data-placeholder');
                
                if (content && content !== placeholder) {
                    localStorage.setItem(storageKey, content);
                    Swal.fire({
                        toast: true,
                        position: 'bottom-end',
                        icon: 'success',
                        title: 'Reminder saved!',
                        showConfirmButton: false,
                        timer: 1500,
                        background: '#10b981',
                        color: '#fff'
                    });
                } else {
                    localStorage.removeItem(storageKey);
                }
            });

            // Prevent div explosion on enter
            field.addEventListener('keypress', (e) => {
                if(e.which === 13) {
                    e.preventDefault();
                    document.execCommand('insertLineBreak');
                }
            });
        });
    </script>
</body>
</html>
