<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Result Card</title>
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

        .header-title {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 4px;
        }

        .muted {
            color: #6b7280;
        }

        .meta-table {
            width: 100%;
            margin-top: 14px;
            border-collapse: separate;
            border-spacing: 10px;
        }

        .meta-box {
            border: 1px solid #d1d5db;
            border-radius: 8px;
            padding: 10px;
            min-height: 62px;
        }

        .meta-label {
            font-size: 10px;
            color: #6b7280;
            text-transform: uppercase;
            margin-bottom: 4px;
        }

        .meta-value {
            font-size: 14px;
            font-weight: bold;
        }

        .stats-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 10px;
            margin-top: 2px;
        }

        .stats-box {
            border: 1px solid #d1d5db;
            border-radius: 8px;
            padding: 10px;
            text-align: center;
        }

        .stats-label {
            font-size: 10px;
            color: #6b7280;
            text-transform: uppercase;
        }

        .stats-value {
            margin-top: 4px;
            font-size: 16px;
            font-weight: bold;
        }

        .section-title {
            font-size: 14px;
            font-weight: bold;
            margin: 16px 0 8px;
        }

        table.marks {
            width: 100%;
            border-collapse: collapse;
        }

        table.marks th,
        table.marks td {
            border: 1px solid #d1d5db;
            padding: 8px;
            vertical-align: middle;
        }

        table.marks th {
            background: #f3f4f6;
            text-align: left;
            font-size: 11px;
        }

        .text-center {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="sheet">
        <div class="header">
            <div class="header-title">Official Result Card</div>
            <div>Academic performance summary and assessment details</div>
        </div>

        <table class="meta-table">
            <tr>
                <td width="50%">
                    <div class="meta-box">
                        <div class="meta-label">Student Name</div>
                        <div class="meta-value">{{ auth()->user()->name }}</div>
                    </div>
                </td>
                <td width="50%">
                    <div class="meta-box">
                        <div class="meta-label">Student ID</div>
                        <div class="meta-value">{{ $student->student_id ?? ('STU-' . $student->id) }}</div>
                    </div>
                </td>
            </tr>
        </table>

        <table class="stats-table">
            <tr>
                <td width="20%">
                    <div class="stats-box">
                        <div class="stats-label">Average</div>
                        <div class="stats-value">{{ number_format($averagePercentage, 1) }}%</div>
                    </div>
                </td>
                <td width="20%">
                    <div class="stats-box">
                        <div class="stats-label">Pass Rate</div>
                        <div class="stats-value">{{ number_format($passRate, 1) }}%</div>
                    </div>
                </td>
                <td width="20%">
                    <div class="stats-box">
                        <div class="stats-label">Subjects</div>
                        <div class="stats-value">{{ $totalSubjects }}</div>
                    </div>
                </td>
                <td width="20%">
                    <div class="stats-box">
                        <div class="stats-label">Highest</div>
                        <div class="stats-value">{{ number_format($highestPercentage, 1) }}%</div>
                    </div>
                </td>
                <td width="20%">
                    <div class="stats-box">
                        <div class="stats-label">Lowest</div>
                        <div class="stats-value">{{ number_format($lowestPercentage, 1) }}%</div>
                    </div>
                </td>
            </tr>
        </table>

        <div class="section-title">Assessment Breakdown</div>
        <table class="marks">
            <thead>
                <tr>
                    <th width="27%">Course</th>
                    <th width="29%">Assessment</th>
                    <th width="16%" class="text-center">Marks</th>
                    <th width="14%" class="text-center">Percentage</th>
                    <th width="14%" class="text-center">Grade</th>
                </tr>
            </thead>
            <tbody>
                @forelse($grades as $grade)
                    <tr>
                        <td>{{ $grade->course->title ?? 'N/A' }}</td>
                        <td>{{ $grade->assignment->title ?? $grade->exam->title ?? 'General Assessment' }}</td>
                        <td class="text-center">{{ $grade->marks_obtained }} / {{ $grade->total_marks }}</td>
                        <td class="text-center">{{ number_format($grade->percentage, 1) }}%</td>
                        <td class="text-center">{{ $grade->grade }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center muted">No records found for selected filters.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <p class="muted" style="margin-top:12px;">
            Generated on {{ now()->format('M d, Y h:i A') }}
        </p>
    </div>
</body>
</html>
