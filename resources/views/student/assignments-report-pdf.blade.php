<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Assignments Report</title>
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

        .box {
            border: 1px solid #d1d5db;
            border-radius: 8px;
            background: #f9fafb;
            padding: 10px;
            text-align: center;
        }

        .label {
            font-size: 10px;
            color: #6b7280;
            text-transform: uppercase;
        }

        .value {
            font-size: 16px;
            font-weight: bold;
            margin-top: 4px;
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
    </style>
</head>
<body>
    <div class="sheet">
        <div class="header">
            <div class="title">Assignments Progress Report</div>
            <div>{{ auth()->user()->name }} | Student ID: {{ $student->student_id ?? ('STU-' . $student->id) }}</div>
        </div>

        <table class="stats">
            <tr>
                <td width="16.66%"><div class="box"><div class="label">Total</div><div class="value">{{ $stats['total'] }}</div></div></td>
                <td width="16.66%"><div class="box"><div class="label">Pending</div><div class="value">{{ $stats['pending'] }}</div></div></td>
                <td width="16.66%"><div class="box"><div class="label">Submitted</div><div class="value">{{ $stats['submitted'] }}</div></div></td>
                <td width="16.66%"><div class="box"><div class="label">Overdue</div><div class="value">{{ $stats['overdue'] }}</div></div></td>
                <td width="16.66%"><div class="box"><div class="label">Critical</div><div class="value">{{ $stats['critical'] }}</div></div></td>
                <td width="16.66%"><div class="box"><div class="label">Avg Score</div><div class="value">{{ is_null($stats['avg_score']) ? 'N/A' : number_format($stats['avg_score'], 1) }}</div></div></td>
            </tr>
        </table>

        <table class="report">
            <thead>
                <tr>
                    <th width="28%">Assignment</th>
                    <th width="20%">Course</th>
                    <th width="11%">Status</th>
                    <th width="16%">Due Date</th>
                    <th width="10%" class="text-center">Days Left</th>
                    <th width="15%">Score</th>
                </tr>
            </thead>
            <tbody>
                @forelse($assignmentCards as $card)
                    @php
                        $assignment = $card['assignment'];
                        $submission = $card['submission'];
                    @endphp
                    <tr>
                        <td>{{ $assignment->title }}</td>
                        <td>{{ $assignment->course->title ?? 'N/A' }}</td>
                        <td>{{ ucfirst($card['status_key']) }}</td>
                        <td>{{ optional($assignment->due_date)->format('M d, Y h:i A') ?? 'N/A' }}</td>
                        <td class="text-center">{{ is_null($card['days_left']) ? 'N/A' : $card['days_left'] }}</td>
                        <td>
                            @if($submission && !is_null($submission->marks_obtained))
                                {{ $submission->marks_obtained }}/{{ $assignment->max_marks }}
                            @elseif($submission)
                                Pending Review
                            @else
                                Not Submitted
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">No assignments found for selected filters.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</body>
</html>
