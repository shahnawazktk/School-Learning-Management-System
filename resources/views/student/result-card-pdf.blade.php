<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>BISE - Detailed Marks Certificate</title>
    <style>
        body { font-family: 'DejaVu Serif', serif; color: #000; font-size: 11px; margin: 0; padding: 15px; }
        
        .dmc-card { 
            background: #fff;
            padding: 30px;
            position: relative;
        }

        .header-top { 
            display: table;
            width: 100%;
            border-bottom: 2px solid #8a2be2; 
            padding-bottom: 10px;
            margin-bottom: 10px;
        }
        
        .board-logo { 
            display: table-cell;
            width: 80px;
            vertical-align: middle;
        }
        
        .logo-circle {
            width: 80px;
            height: 80px;
            border: 2px solid #000;
            border-radius: 50%;
            text-align: center;
            line-height: 80px;
            font-size: 40px;
        }
        
        .header-text { 
            display: table-cell;
            text-align: center;
            vertical-align: middle;
            padding: 0 10px;
        }
        
        .header-text h2 { 
            color: #2c3e50; 
            font-weight: bold; 
            margin: 3px 0; 
            font-size: 18px; 
        }
        
        .header-text h4 { 
            color: #d63384; 
            margin: 3px 0; 
            font-size: 14px; 
        }
        
        .header-text p { 
            font-weight: bold; 
            margin: 3px 0; 
            font-size: 12px;
        }

        .student-photo { 
            display: table-cell;
            width: 90px;
            vertical-align: middle;
        }
        
        .photo-box {
            width: 90px; 
            height: 110px; 
            border: 1px solid #000; 
            text-align: center;
            background: #f5f5f5;
            line-height: 110px;
            font-size: 40px;
        }

        .serial-info { 
            margin: 10px 0;
            font-weight: bold;
            font-size: 11px;
        }
        
        .serial-left { float: left; }
        .serial-right { float: right; }
        .clearfix { clear: both; }

        .details-grid { 
            margin: 15px 0;
            font-size: 11px;
        }
        
        .detail-item { 
            margin: 5px 0;
            border-bottom: 1px dotted #000;
            padding-bottom: 2px;
        }
        
        .detail-row {
            display: table;
            width: 100%;
            margin-bottom: 5px;
        }
        
        .detail-left, .detail-right {
            display: table-cell;
            width: 50%;
            padding-right: 10px;
        }
        
        .label { 
            font-weight: bold;
            display: inline-block;
            width: 110px;
        }
        
        .value { 
            display: inline;
        }

        .marks-table { 
            width: 100%; 
            border-collapse: collapse; 
            margin: 10px 0;
            font-size: 10px;
        }
        
        .marks-table th, .marks-table td { 
            border: 1px solid #000; 
            padding: 4px;
            text-align: center;
        }
        
        .marks-table th { 
            background: #f2f2f2;
            font-weight: bold;
        }
        
        .subject-name { 
            text-align: left !important;
            padding-left: 8px !important;
        }
        
        .total-row {
            background: #eee;
            font-weight: bold;
        }

        .remarks-section {
            margin: 15px 0;
            font-size: 11px;
        }
        
        .remarks-section p {
            margin: 5px 0;
        }

        .footer-sec { 
            margin-top: 40px;
            font-size: 10px;
        }
        
        .sig-table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .sig-box { 
            text-align: center;
            width: 50%;
            padding-top: 50px;
            border-top: 1px solid #000;
            font-weight: bold;
        }

        .footer-note {
            text-align: center;
            font-size: 9px;
            margin-top: 15px;
            padding-top: 10px;
            border-top: 1px solid #000;
        }
    </style>
</head>
<body>
    <div class="dmc-card">
        <div class="header-top">
            <div class="board-logo">
                <div class="logo-circle">🎓</div>
            </div>
            <div class="header-text">
                <h2>BOARD OF INTERMEDIATE AND SECONDARY EDUCATION</h2>
                <h2>{{ strtoupper($student->state ?? 'PAKISTAN') }}</h2>
                <h4>{{ $student->country ?? 'Pakistan' }}</h4>
                <p>DETAILED MARKS CERTIFICATE</p>
                <small>Secondary School Certificate Examination</small>
            </div>
            <div class="student-photo">
                <div class="photo-box">👤</div>
            </div>
        </div>
        <div class="clearfix"></div>

        <div class="serial-info">
            <div class="serial-left">S.No: <span style="color: #d63384;">{{ str_pad($student->id, 6, '0', STR_PAD_LEFT) }}</span></div>
            <div class="serial-right">Session: <strong>{{ $student->academic_year ?? date('Y') }} (Annual)</strong></div>
        </div>
        <div class="clearfix"></div>

        <div class="details-grid">
            <div class="detail-row">
                <div class="detail-left">
                    <span class="label">Enrol No:</span>
                    <span class="value">{{ $student->student_id ?? 'N/A' }}</span>
                </div>
                <div class="detail-right">
                    <span class="label">Class:</span>
                    <span class="value">{{ strtoupper($student->class ?? 'N/A') }}</span>
                </div>
            </div>
            <div class="detail-row">
                <div class="detail-left">
                    <span class="label">Roll No:</span>
                    <span class="value"><strong>{{ $student->roll_number ?? 'N/A' }}</strong></span>
                </div>
                <div class="detail-right">
                    <span class="label">Section:</span>
                    <span class="value">{{ strtoupper($student->section ?? 'N/A') }}</span>
                </div>
            </div>
            <div class="detail-row">
                <div class="detail-left">
                    <span class="label">Name:</span>
                    <span class="value">{{ auth()->user()->name }}</span>
                </div>
                <div class="detail-right">
                    <span class="label">Father Name:</span>
                    <span class="value">{{ $student->emergency_contact ?? 'N/A' }}</span>
                </div>
            </div>
        </div>

        @php
            $subjectGrades = $grades->groupBy('course_id')->map(function($courseGrades) {
                return [
                    'course' => $courseGrades->first()->course,
                    'total_marks' => $courseGrades->sum('total_marks'),
                    'marks_obtained' => $courseGrades->sum('marks_obtained'),
                    'percentage' => $courseGrades->avg('percentage'),
                    'grade' => $courseGrades->first()->grade
                ];
            })->values();
            
            $totalMarks = $subjectGrades->sum('total_marks');
            $totalObtained = $subjectGrades->sum('marks_obtained');
            $overallPercentage = $totalMarks > 0 ? ($totalObtained / $totalMarks) * 100 : 0;
            $isPassed = $overallPercentage >= 40 && $subjectGrades->every(fn($s) => $s['percentage'] >= 33);
            
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
                    <th style="width: 30px;">S.No</th>
                    <th style="width: 180px;">Subjects</th>
                    <th style="width: 70px;">Total Marks</th>
                    <th style="width: 80px;">Marks Obtained</th>
                    <th style="width: 60px;">Percentage</th>
                    <th style="width: 40px;">Grade</th>
                    <th>In Words</th>
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
                        <td colspan="7" style="text-align: center; padding: 20px;">No examination records found</td>
                    </tr>
                @endforelse
                
                @if($subjectGrades->isNotEmpty())
                    <tr class="total-row">
                        <td colspan="2" style="text-align: right;">Total</td>
                        <td>{{ number_format($totalMarks) }}</td>
                        <td colspan="2"><strong>{{ number_format($totalObtained) }}</strong></td>
                        <td colspan="2">{{ ucwords(numberToWords((int)$totalObtained)) }} Only</td>
                    </tr>
                @endif
            </tbody>
        </table>

        @if($subjectGrades->isNotEmpty())
            <div class="remarks-section">
                <p><strong>Date of Birth:</strong> {{ $student->date_of_birth ? $student->date_of_birth->format('d-m-Y') : 'N/A' }}</p>
                <p><strong>Overall Percentage:</strong> {{ number_format($overallPercentage, 2) }}%</p>
                <p><strong>Remarks:</strong> <span style="color: {{ $isPassed ? '#28a745' : '#dc3545' }}; font-weight: bold;">{{ $isPassed ? 'PASSED' : 'FAILED' }}</span></p>
            </div>
        @endif

        <div class="footer-sec">
            <table class="sig-table">
                <tr>
                    <td class="sig-box">Checked By</td>
                    <td class="sig-box">Controller of Examinations</td>
                </tr>
            </table>
        </div>
        
        <div class="footer-note">
            Note: This is a verified electronic copy. Any alteration renders this document invalid.<br>
            Issued on: {{ now()->format('d-m-Y') }} | Document No: DMC/{{ $student->id }}/{{ date('Y') }}/{{ str_pad($student->id, 5, '0', STR_PAD_LEFT) }}
        </div>
    </div>
</body>
</html>
