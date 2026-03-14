<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Exam Admit Card</title>
    <style>
        /* PDF specific fonts and styles */
        body {
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
            color: #1e293b;
            font-size: 13px;
            margin: 0;
            padding: 0;
            background: #ffffff;
        }

        .container {
            padding: 30px;
        }

        /* Header Header */
        .header-box {
            background-color: #1e3a8a;
            color: #ffffff;
            padding: 25px;
            border-radius: 10px;
            margin-bottom: 30px;
        }
        
        .header-table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .header-title {
            font-size: 24px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin: 0;
        }
        
        .header-subtitle {
            font-size: 14px;
            color: #bfdbfe;
            margin-top: 5px;
        }

        .card-id-badge {
            background-color: #ffffff;
            color: #1e3a8a;
            padding: 6px 15px;
            border-radius: 20px;
            font-weight: bold;
            font-size: 12px;
            display: inline-block;
        }

        /* General Table layout */
        .info-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 15px;
            margin-top: -15px;
            margin-bottom: 20px;
        }

        .box {
            border: 2px solid #e2e8f0;
            background-color: #f8fafc;
            border-radius: 8px;
            padding: 15px;
        }

        .label {
            color: #64748b;
            font-size: 11px;
            text-transform: uppercase;
            font-weight: bold;
            margin-bottom: 6px;
        }

        .value {
            font-size: 16px;
            font-weight: bold;
            color: #0f172a;
        }

        /* Sections */
        .section-title {
            font-size: 16px;
            font-weight: bold;
            color: #1e3a8a;
            border-bottom: 2px solid #e2e8f0;
            padding-bottom: 8px;
            margin-bottom: 15px;
            margin-top: 25px;
        }

        .rules-list {
            margin: 0;
            padding-left: 20px;
            color: #334155;
            line-height: 1.6;
        }
        .rules-list li {
            margin-bottom: 8px;
        }

        /* Footer */
        .footer {
            margin-top: 40px;
            padding-top: 15px;
            border-top: 1px dashed #cbd5e1;
            text-align: center;
            font-size: 11px;
            color: #64748b;
        }
        
        .barcode-text {
            font-family: monospace;
            font-size: 14px;
            letter-spacing: 3px;
            margin-top: 10px;
            color: #000;
        }

        .result-box {
            background-color: #f0fdf4;
            border: 2px solid #bbf7d0;
            padding: 15px;
            border-radius: 8px;
            margin-top: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header-box">
            <table class="header-table">
                <tr>
                    <td width="70%">
                        <div class="header-title">Official Admit Card</div>
                        <div class="header-subtitle">Academic Examination Session</div>
                    </td>
                    <td width="30%" align="right" valign="middle">
                        <div class="card-id-badge">
                            EXAM-{{ $exam->id }}-STU-{{ $student->id }}
                        </div>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Candidate Details -->
        <div class="section-title">Candidate Details</div>
        <table class="info-table">
            <tr>
                <td width="50%" valign="top">
                    <div class="box">
                        <div class="label">Student Name</div>
                        <div class="value">{{ auth()->user()->name }}</div>
                    </div>
                </td>
                <td width="50%" valign="top">
                    <div class="box">
                        <div class="label">Roll No. / Student ID</div>
                        <div class="value">{{ $student->student_id ?? ('STU-' . str_pad($student->id, 5, '0', STR_PAD_LEFT)) }}</div>
                    </div>
                </td>
            </tr>
            <tr>
                <td width="50%" valign="top">
                    <div class="box">
                        <div class="label">Course / Subject</div>
                        <div class="value">{{ $exam->course->title ?? 'N/A' }}</div>
                    </div>
                </td>
                <td width="50%" valign="top">
                    <div class="box">
                        <div class="label">Examination Type</div>
                        <div class="value">{{ ucfirst($exam->type ?? 'General') }}</div>
                    </div>
                </td>
            </tr>
        </table>

        <!-- Examination Schedule -->
        <div class="section-title">Examination Schedule</div>
        <table class="info-table">
            <tr>
                <td width="33.3%" valign="top">
                    <div class="box" style="text-align: center; background-color: #eff6ff; border-color: #bfdbfe;">
                        <div class="label">Exam Date</div>
                        <div class="value" style="color: #1e3a8a;">{{ optional($exam->exam_date)->format('M d, Y') ?? 'N/A' }}</div>
                    </div>
                </td>
                <td width="33.3%" valign="top">
                    <div class="box" style="text-align: center; background-color: #eff6ff; border-color: #bfdbfe;">
                        <div class="label">Time Window</div>
                        <div class="value" style="color: #1e3a8a;">
                            {{ $exam->start_time ? date('h:i A', strtotime($exam->start_time)) : 'TBD' }}
                            <br><span style="font-size:12px; font-weight:normal;">to</span><br>
                            {{ $exam->end_time ? date('h:i A', strtotime($exam->end_time)) : 'TBD' }}
                        </div>
                    </div>
                </td>
                <td width="33.3%" valign="top">
                    <div class="box" style="text-align: center; background-color: #eff6ff; border-color: #bfdbfe;">
                        <div class="label">Assessment Points</div>
                        <div class="value" style="color: #1e3a8a;">{{ $exam->total_marks ?? 'N/A' }} Marks</div>
                    </div>
                </td>
            </tr>
        </table>

        <!-- Results if Available -->
        @if($gradeScore)
        <div class="section-title" style="margin-top: 15px;">Official Result</div>
        <div class="result-box">
            <table width="100%">
                <tr>
                    <td width="100%">
                        <div style="font-size: 16px; font-weight: bold; color: #14532d;">
                            Marks Obtained: {{ $gradeScore->marks_obtained }} / {{ $gradeScore->total_marks }}
                            &nbsp;|&nbsp;
                            Grade: {{ $gradeScore->grade }} ({{ number_format($gradeScore->percentage, 1) }}%)
                        </div>
                    </td>
                </tr>
            </table>
        </div>
        @endif

        <!-- Examination Rules -->
        <div class="section-title">Examination Directives</div>
        <ol class="rules-list">
            <li>Candidates must occupy their assigned seats <strong>30 minutes</strong> before the commencement of the examination.</li>
            <li>This Admit Card and a valid institutional ID are <strong>mandatory</strong> for entry into the examination hall.</li>
            <li>Electronic gadgets, smartwatches, unauthorized materials, or communication devices are strictly prohibited.</li>
            <li>Violation of examination rules may result in immediate disqualification and subsequent disciplinary action.</li>
            <li>Do not write anything on this admit card unless requested by the invigilator.</li>
        </ol>

        <!-- Signature Area -->
        <table width="100%" style="margin-top: 40px;">
            <tr>
                <td width="33%" align="center">
                    <div style="border-bottom: 1px solid #1e293b; width: 80%; height: 30px;"></div>
                    <div style="font-size: 11px; margin-top: 5px; font-weight: bold;">Candidate Signature</div>
                </td>
                <td width="33%"></td>
                <td width="33%" align="center">
                    <div style="border-bottom: 1px solid #1e293b; width: 80%; height: 30px;"></div>
                    <div style="font-size: 11px; margin-top: 5px; font-weight: bold;">Invigilator Signature</div>
                </td>
            </tr>
        </table>

        <!-- Footer -->
        <div class="footer">
            Document generated electronically by the LMS System on {{ now()->format('F d, Y h:i A') }}
            <br>
            <div class="barcode-text">*{{ $exam->id }}00{{ $student->id }}*</div>
        </div>
    </div>
</body>
</html>
