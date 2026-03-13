<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BISE - Detailed Marks Certificate</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap');
        
        body { background: #e0e0e0; font-family: 'Times New Roman', serif; padding: 20px 0; }
        
        /* Document Paper Styling */
        .dmc-card { 
            max-width: 950px; 
            margin: auto; 
            background: #fffdf7; /* Off-white paper look */
            padding: 40px; 
            border: 1px solid #ccc;
            position: relative;
            box-shadow: 0 0 15px rgba(0,0,0,0.2);
        }

        /* Watermark */
        .dmc-card::before {
            content: "BISE";
            position: absolute;
            top: 50%; left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 80px;
            color: rgba(0,0,0,0.03);
            pointer-events: none;
            white-space: nowrap;
        }

        .header-top { display: flex; align-items: center; justify-content: space-between; border-bottom: 2px solid #8a2be2; padding-bottom: 10px; }
        .board-logo { width: 100px; height: 100px; }
        .header-text { text-align: center; flex-grow: 1; }
        .header-text h2 { color: #2c3e50; font-weight: bold; margin: 0; font-size: 24px; }
        .header-text h4 { color: #d63384; margin: 5px 0; font-size: 18px; }
        .header-text p { font-weight: bold; margin: 0; color: #555; }

        .serial-info { display: flex; justify-content: space-between; margin-top: 15px; font-weight: bold; }

        /* Student Details Grid */
        .details-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin: 20px 0; }
        .detail-item { display: flex; border-bottom: 1px dotted #000; padding-bottom: 2px; }
        .label { font-weight: bold; width: 130px; }
        .value { flex: 1; }
        .student-photo { width: 110px; height: 130px; border: 1px solid #000; text-align: center; display: flex; align-items: center; justify-content: center; background: #f5f5f5; }
        .student-photo img { width: 100%; height: 100%; object-fit: cover; }

        /* Marks Table - BISE Style */
        .marks-table { width: 100%; border-collapse: collapse; margin-top: 10px; font-size: 13px; }
        .marks-table th, .marks-table td { border: 1px solid #000; padding: 4px 6px; text-align: center; }
        .marks-table th { background: #f2f2f2; }
        .subject-name { text-align: left !important; padding-left: 10px !important; }

        .footer-sec { display: flex; justify-content: space-between; margin-top: 50px; }
        .sig-box { text-align: center; min-width: 150px; border-top: 1px solid #000; padding-top: 5px; font-weight: bold; }

        @media print {
            body { background: none; padding: 0; }
            .dmc-card { box-shadow: none; border: none; width: 100%; max-width: 100%; }
            .no-print { display: none; }
        }
    </style>
</head>
<body>

<div class="container text-center mb-3 no-print">
    <a href="{{ route('student.results', request()->query()) }}" class="btn btn-secondary me-2">Back to Results</a>
    <button class="btn btn-primary" onclick="window.print()">Print DMC</button>
    <a href="{{ route('student.results.card.download', request()->query()) }}" class="btn btn-success ms-2">Download PDF</a>
</div>

<div class="dmc-card">
    <div class="header-top">
        <div class="board-logo" style="border: 2px solid #000; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 40px;">
            🎓
        </div>
        <div class="header-text">
            <h2>BOARD OF INTERMEDIATE AND SECONDARY EDUCATION</h2>
            <h2>{{ strtoupper($student->state ?? 'PAKISTAN') }}</h2>
            <h4>{{ $student->country ?? 'Pakistan' }}</h4>
            <p>DETAILED MARKS CERTIFICATE</p>
            <small>Secondary School Certificate Examination</small>
        </div>
        <div class="student-photo">
            @if($student->profile_image)
                <img src="{{ asset('storage/' . $student->profile_image) }}" alt="Student Photo">
            @else
                <span style="font-size: 50px;">👤</span>
            @endif
        </div>
    </div>

    <div class="serial-info">
        <div>S.No: <span class="text-danger">{{ str_pad($student->id, 6, '0', STR_PAD_LEFT) }}</span></div>
        <div class="text-end">Session: <strong>{{ $student->academic_year ?? date('Y') }} (Annual)</strong></div>
    </div>

    <div class="details-grid">
        <div class="detail-item"><span class="label">Enrol No:</span><span class="value">{{ $student->student_id ?? 'N/A' }}</span></div>
        <div class="detail-item"><span class="label">Class:</span><span class="value">{{ strtoupper($student->class ?? 'N/A') }}</span></div>
        <div class="detail-item"><span class="label">Roll No:</span><span class="value"><strong>{{ $student->roll_number ?? 'N/A' }}</strong></span></div>
        <div class="detail-item"><span class="label">Section:</span><span class="value">{{ strtoupper($student->section ?? 'N/A') }}</span></div>
        <div class="detail-item"><span class="label">Name:</span><span class="value">{{ auth()->user()->name }}</span></div>
        <div class="detail-item"><span class="label">Father Name:</span><span class="value">{{ $student->emergency_contact ?? 'N/A' }}</span></div>
    </div>

    @php
        // Group grades by course/subject
        $subjectGrades = $grades->groupBy('course_id')->map(function($courseGrades) {
            $course = $courseGrades->first()->course;
            return [
                'course' => $course,
                'total_marks' => $courseGrades->sum('total_marks'),
                'marks_obtained' => $courseGrades->sum('marks_obtained'),
                'percentage' => $courseGrades->avg('percentage'),
                'grade' => $courseGrades->first()->grade,
                'grades' => $courseGrades
            ];
        })->values();
        
        $totalMarks = $subjectGrades->sum('total_marks');
        $totalObtained = $subjectGrades->sum('marks_obtained');
        $overallPercentage = $totalMarks > 0 ? ($totalObtained / $totalMarks) * 100 : 0;
        $isPassed = $overallPercentage >= 40 && $subjectGrades->every(fn($s) => $s['percentage'] >= 33);
        
        // Convert number to words function
        function numberToWords($number) {
            $ones = ['', 'One', 'Two', 'Three', 'Four', 'Five', 'Six', 'Seven', 'Eight', 'Nine'];
            $tens = ['', '', 'Twenty', 'Thirty', 'Forty', 'Fifty', 'Sixty', 'Seventy', 'Eighty', 'Ninety'];
            $teens = ['Ten', 'Eleven', 'Twelve', 'Thirteen', 'Fourteen', 'Fifteen', 'Sixteen', 'Seventeen', 'Eighteen', 'Nineteen'];
            
            if ($number < 10) return $ones[$number];
            if ($number < 20) return $teens[$number - 10];
            if ($number < 100) return $tens[floor($number / 10)] . ' ' . $ones[$number % 10];
            if ($number < 1000) return $ones[floor($number / 100)] . ' Hundred ' . numberToWords($number % 100);
            return 'Number too large';
        }
    @endphp

    <table class="marks-table">
        <thead>
            <tr>
                <th rowspan="2">S.No</th>
                <th rowspan="2" style="width: 30%;">Subjects</th>
                <th rowspan="2">Total Marks</th>
                <th rowspan="2">Marks Obtained</th>
                <th rowspan="2">Percentage</th>
                <th rowspan="2">Grade</th>
                <th rowspan="2">In Words</th>
            </tr>
        </thead>
        <tbody>
            @forelse($subjectGrades as $index => $subject)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td class="subject-name">{{ $subject['course']->title ?? 'N/A' }}</td>
                    <td>{{ number_format($subject['total_marks']) }}</td>
                    <td><strong>{{ number_format($subject['marks_obtained']) }}</strong></td>
                    <td>{{ number_format($subject['percentage'], 2) }}%</td>
                    <td><strong>{{ $subject['grade'] }}</strong></td>
                    <td>{{ ucwords(numberToWords((int)$subject['marks_obtained'])) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align: center; padding: 30px;">No examination records found</td>
                </tr>
            @endforelse
            
            @if($subjectGrades->isNotEmpty())
                <tr style="font-weight: bold; background: #eee;">
                    <td colspan="2" class="text-end">Total</td>
                    <td>{{ number_format($totalMarks) }}</td>
                    <td colspan="2"><strong>{{ number_format($totalObtained) }}</strong></td>
                    <td colspan="2">{{ ucwords(numberToWords((int)$totalObtained)) }} Only</td>
                </tr>
            @endif
        </tbody>
    </table>

    @if($subjectGrades->isNotEmpty())
        <div class="mt-4">
            <p><strong>Date of Birth:</strong> {{ $student->date_of_birth ? $student->date_of_birth->format('d-m-Y') : 'N/A' }}</p>
            <p><strong>Overall Percentage:</strong> {{ number_format($overallPercentage, 2) }}%</p>
            <p><strong>Remarks:</strong> <span style="color: {{ $isPassed ? 'green' : 'red' }}; font-weight: bold;">{{ $isPassed ? 'PASSED' : 'FAILED' }}</span></p>
        </div>
    @endif

    <div class="footer-sec">
        <div class="sig-box">Checked By</div>
        <div class="sig-box">Controller of Examinations</div>
    </div>
    
    <div class="text-center mt-4" style="font-size: 11px; border-top: 1px solid #ddd; padding-top: 10px;">
        Note: This is a verified electronic copy. Any alteration renders this document invalid.<br>
        Issued on: {{ now()->format('d-m-Y') }} | Document No: DMC/{{ $student->id }}/{{ date('Y') }}/{{ str_pad($student->id, 5, '0', STR_PAD_LEFT) }}
    </div>
</div>

</body>
</html>