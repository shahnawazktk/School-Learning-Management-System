<h2 style="margin-bottom:12px;">Assignment Reminder</h2>
<p>Hello {{ auth()->user()->name }},</p>
<p>You have <strong>{{ $pendingAssignments->count() }}</strong> pending assignment(s) due in the next <strong>{{ $days }}</strong> day(s).</p>

<table cellpadding="8" cellspacing="0" border="1" style="border-collapse:collapse; width:100%; border-color:#e5e7eb;">
    <thead style="background:#f3f4f6;">
        <tr>
            <th align="left">Assignment</th>
            <th align="left">Course</th>
            <th align="left">Due Date</th>
        </tr>
    </thead>
    <tbody>
        @foreach($pendingAssignments as $assignment)
            <tr>
                <td>{{ $assignment->title }}</td>
                <td>{{ $assignment->course->title ?? 'N/A' }}</td>
                <td>{{ optional($assignment->due_date)->format('M d, Y h:i A') ?? 'N/A' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

<p style="margin-top:12px;">Please submit on time to avoid late penalties.</p>
