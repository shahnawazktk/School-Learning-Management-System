<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Subject Progress Report</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            color: #1f2937;
            font-size: 12px;
            margin: 0;
            padding: 0;
        }

        .sheet {
            padding: 20px 24px;
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

        .stats {
            width: 100%;
            border-collapse: separate;
            border-spacing: 10px;
            margin-top: 12px;
        }

        .stat-box {
            border: 1px solid #d1d5db;
            border-radius: 8px;
            padding: 10px;
            text-align: center;
            background: #f9fafb;
        }

        .stat-label {
            font-size: 10px;
            color: #6b7280;
            text-transform: uppercase;
        }

        .stat-value {
            margin-top: 4px;
            font-size: 16px;
            font-weight: bold;
        }

        table.report {
            width: 100%;
            border-collapse: collapse;
            margin-top: 14px;
        }

        table.report th,
        table.report td {
            border: 1px solid #d1d5db;
            padding: 8px;
            vertical-align: middle;
        }

        table.report th {
            background: #f3f4f6;
            text-align: left;
            font-size: 11px;
        }

        .text-center {
            text-align: center;
        }

        .muted {
            color: #6b7280;
        }
    </style>
</head>
<body>
    <div class="sheet">
        <div class="header">
            <div class="title">Student Subject Progress Report</div>
            <div>{{ auth()->user()->name }} | Student ID: {{ $student->student_id ?? ('STU-' . $student->id) }}</div>
        </div>

        <table class="stats">
            <tr>
                <td width="16.66%"><div class="stat-box"><div class="stat-label">Total</div><div class="stat-value">{{ $stats['total_subjects'] }}</div></div></td>
                <td width="16.66%"><div class="stat-box"><div class="stat-label">Active</div><div class="stat-value">{{ $stats['active_subjects'] }}</div></div></td>
                <td width="16.66%"><div class="stat-box"><div class="stat-label">Credits</div><div class="stat-value">{{ $stats['total_credits'] }}</div></div></td>
                <td width="16.66%"><div class="stat-box"><div class="stat-label">Avg Progress</div><div class="stat-value">{{ $stats['average_progress'] }}%</div></div></td>
                <td width="16.66%"><div class="stat-box"><div class="stat-label">Due in 7 Days</div><div class="stat-value">{{ $stats['upcoming_deadlines'] }}</div></div></td>
                <td width="16.66%"><div class="stat-box"><div class="stat-label">At Risk</div><div class="stat-value">{{ $stats['at_risk'] }}</div></div></td>
            </tr>
        </table>

        <table class="report">
            <thead>
                <tr>
                    <th width="26%">Course</th>
                    <th width="11%">Code</th>
                    <th width="10%">Credits</th>
                    <th width="16%">Instructor</th>
                    <th width="11%">Status</th>
                    <th width="10%" class="text-center">Progress</th>
                    <th width="16%">Next Due</th>
                </tr>
            </thead>
            <tbody>
                @forelse($subjectCards as $card)
                    @php
                        $course = $card['course'];
                        $subject = $card['subject'];
                        $teacher = $card['teacher'];
                        $enrollment = $card['enrollment'];
                    @endphp
                    <tr>
                        <td>{{ $course->title ?? $subject->name ?? 'Untitled Subject' }}</td>
                        <td>{{ $subject->code ?? 'N/A' }}</td>
                        <td>{{ $subject->credits ?? 0 }}</td>
                        <td>{{ $teacher->name ?? 'Not assigned' }}</td>
                        <td>{{ ucfirst($enrollment->status ?? 'N/A') }}</td>
                        <td class="text-center">{{ $card['completion'] }}%</td>
                        <td>
                            @if($card['next_due'] && $card['next_due']->due_date)
                                {{ $card['next_due']->due_date->format('M d, Y h:i A') }}
                            @else
                                N/A
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center muted">No subjects found for selected filters.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <p class="muted" style="margin-top: 12px;">Generated on {{ now()->format('M d, Y h:i A') }}</p>
    </div>
</body>
</html>
