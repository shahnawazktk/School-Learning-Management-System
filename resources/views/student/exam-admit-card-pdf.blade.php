<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Exam Admit Card</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            color: #1f2937;
            font-size: 12px;
            margin: 0;
            padding: 0;
        }

        .sheet {
            padding: 22px 24px;
        }

        .header {
            background: #0b5e89;
            color: #ffffff;
            padding: 14px 16px;
            border-radius: 8px;
        }

        .title {
            font-size: 19px;
            font-weight: bold;
            margin-bottom: 4px;
        }

        .table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 10px;
            margin-top: 12px;
        }

        .box {
            border: 1px solid #d1d5db;
            border-radius: 8px;
            padding: 10px;
            min-height: 64px;
            background: #f9fafb;
        }

        .label {
            color: #6b7280;
            font-size: 10px;
            text-transform: uppercase;
            margin-bottom: 4px;
        }

        .value {
            font-size: 14px;
            font-weight: bold;
        }

        .section {
            margin-top: 12px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            padding: 10px;
        }

        .muted {
            color: #6b7280;
        }
    </style>
</head>
<body>
    <div class="sheet">
        <div class="header">
            <div class="title">Exam Admit Card</div>
            <div>Card ID: EXAM-{{ $exam->id }}-STU-{{ $student->id }}</div>
        </div>

        <table class="table">
            <tr>
                <td width="50%">
                    <div class="box">
                        <div class="label">Student Name</div>
                        <div class="value">{{ auth()->user()->name }}</div>
                    </div>
                </td>
                <td width="50%">
                    <div class="box">
                        <div class="label">Student ID</div>
                        <div class="value">{{ $student->student_id ?? ('STU-' . $student->id) }}</div>
                    </div>
                </td>
            </tr>
            <tr>
                <td width="50%">
                    <div class="box">
                        <div class="label">Course</div>
                        <div class="value">{{ $exam->course->title ?? 'N/A' }}</div>
                    </div>
                </td>
                <td width="50%">
                    <div class="box">
                        <div class="label">Exam Type</div>
                        <div class="value">{{ ucfirst($exam->type ?? 'General') }}</div>
                    </div>
                </td>
            </tr>
            <tr>
                <td width="33.33%">
                    <div class="box">
                        <div class="label">Exam Date</div>
                        <div class="value">{{ optional($exam->exam_date)->format('M d, Y') ?? 'N/A' }}</div>
                    </div>
                </td>
                <td width="33.33%">
                    <div class="box">
                        <div class="label">Exam Time</div>
                        <div class="value">
                            {{ $exam->start_time ? date('h:i A', strtotime($exam->start_time)) : 'TBD' }}
                            -
                            {{ $exam->end_time ? date('h:i A', strtotime($exam->end_time)) : 'TBD' }}
                        </div>
                    </div>
                </td>
                <td width="33.33%">
                    <div class="box">
                        <div class="label">Total Marks</div>
                        <div class="value">{{ $exam->total_marks ?? 'N/A' }}</div>
                    </div>
                </td>
            </tr>
        </table>

        <div class="section">
            <div><strong>Status:</strong> {{ ucfirst($exam->status ?? 'Scheduled') }}</div>
            @if($gradeScore)
                <div style="margin-top: 6px;"><strong>Result:</strong> {{ $gradeScore->marks_obtained }}/{{ $gradeScore->total_marks }} | {{ $gradeScore->grade }} ({{ number_format($gradeScore->percentage, 1) }}%)</div>
            @endif
        </div>

        <div class="section">
            <div><strong>Exam Instructions</strong></div>
            <ol class="muted" style="margin: 8px 0 0 16px; padding: 0;">
                <li>Reach exam venue at least 30 minutes before start time.</li>
                <li>Carry this admit card and valid student ID card.</li>
                <li>Follow all invigilator instructions during the exam.</li>
            </ol>
        </div>

        <p class="muted" style="margin-top: 12px;">Generated on {{ now()->format('M d, Y h:i A') }}</p>
    </div>
</body>
</html>
