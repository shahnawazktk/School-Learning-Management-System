@extends('layouts.student.app')

@section('content')
<div class="container-fluid p-4">
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Admission request submit nahi hui.</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
        <div>
            <h4 class="mb-1"><i class="fas fa-file-signature text-primary me-2"></i>New Admission Portal</h4>
            <p class="text-muted mb-0">Complete student profile, fee standing, aur admission application ek hi jagah.</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('student.new-admission') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus me-1"></i>New Admission
            </a>
            <a href="{{ route('student.dashboard') }}" class="btn btn-outline-secondary btn-sm">
                <i class="fas fa-arrow-left me-1"></i>Back to Dashboard
            </a>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    @if(!empty($student->profile_image))
                        <img src="{{ asset('storage/' . $student->profile_image) }}" alt="Student Profile" class="rounded-circle mb-3" style="width: 120px; height: 120px; object-fit: cover;">
                    @else
                        <div class="rounded-circle bg-primary-subtle text-primary d-inline-flex align-items-center justify-content-center mb-3" style="width: 120px; height: 120px; font-size: 38px; font-weight: 700;">
                            {{ strtoupper(substr((string) auth()->user()->name, 0, 2)) }}
                        </div>
                    @endif
                    <h5 class="mb-1">{{ auth()->user()->name }}</h5>
                    <p class="text-muted mb-2">{{ $student->student_id ?? 'N/A' }}</p>
                    <span class="badge bg-primary">{{ $student->class ?? 'N/A' }} - {{ $student->section ?? 'N/A' }}</span>
                    <hr>
                    <div class="text-start">
                        <div class="mb-2"><strong>Academic Year:</strong> {{ $student->academic_year ?? 'N/A' }}</div>
                        <div class="mb-2"><strong>Roll Number:</strong> {{ $student->roll_number ?? 'N/A' }}</div>
                        <div class="mb-2"><strong>Status:</strong> {{ ucfirst((string) ($student->status ?? 'N/A')) }}</div>
                        <div><strong>Email:</strong> {{ auth()->user()->email ?? 'N/A' }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0"><i class="fas fa-id-card me-2 text-info"></i>Complete Student Data</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table mb-0 align-middle">
                            <tbody>
                                <tr><th width="28%" class="text-muted">Full Name</th><td>{{ auth()->user()->name }}</td></tr>
                                <tr><th class="text-muted">Student ID</th><td>{{ $student->student_id ?? 'N/A' }}</td></tr>
                                <tr><th class="text-muted">Class / Section</th><td>{{ $student->class ?? 'N/A' }} / {{ $student->section ?? 'N/A' }}</td></tr>
                                <tr><th class="text-muted">Date of Birth</th><td>{{ optional($student->date_of_birth)->format('M d, Y') ?? 'N/A' }}</td></tr>
                                <tr><th class="text-muted">Gender</th><td>{{ ucfirst((string) ($student->gender ?? 'N/A')) }}</td></tr>
                                <tr><th class="text-muted">Address</th><td>{{ $student->address ?? 'N/A' }}, {{ $student->city ?? '' }} {{ $student->state ?? '' }} {{ $student->zip_code ?? '' }}</td></tr>
                                <tr><th class="text-muted">Emergency Contact</th><td>{{ $student->emergency_contact ?? 'N/A' }}</td></tr>
                                <tr><th class="text-muted">Active Enrollments</th><td>{{ $enrollments->count() }}</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-money-check-dollar me-2 text-success"></i>Fee Payment Standing</h5>
                    <span class="badge bg-danger-subtle text-danger-emphasis">Pending Bills: {{ $feeStats['pending_count'] }}</span>
                </div>
                <div class="card-body">
                    <div class="row g-3 mb-3">
                        <div class="col-md-4 col-6">
                            <div class="p-3 rounded border bg-light">
                                <small class="text-muted d-block">Total Fee</small>
                                <strong>Rs. {{ number_format($feeStats['total_amount'], 2) }}</strong>
                            </div>
                        </div>
                        <div class="col-md-4 col-6">
                            <div class="p-3 rounded border bg-light">
                                <small class="text-muted d-block">Paid</small>
                                <strong class="text-success">Rs. {{ number_format($feeStats['paid_amount'], 2) }}</strong>
                            </div>
                        </div>
                        <div class="col-md-4 col-12">
                            <div class="p-3 rounded border bg-light">
                                <small class="text-muted d-block">Outstanding</small>
                                <strong class="text-danger">Rs. {{ number_format($feeStats['outstanding_amount'], 2) }}</strong>
                            </div>
                        </div>
                    </div>

                    <h6 class="mb-2">Recent Fee Transactions</h6>
                    @if($feeTransactions->isEmpty())
                        <p class="text-muted mb-0">No payment transaction found.</p>
                    @else
                        <div class="table-responsive">
                            <table class="table table-sm align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Receipt</th>
                                        <th>Bill</th>
                                        <th>Method</th>
                                        <th>Amount</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($feeTransactions as $tx)
                                        <tr>
                                            <td>{{ $tx->receipt_number }}</td>
                                            <td>{{ optional($tx->feePayment)->title ?? 'N/A' }}</td>
                                            <td>{{ ucfirst(str_replace('_', ' ', (string) $tx->payment_method)) }}</td>
                                            <td>Rs. {{ number_format((float) $tx->amount, 2) }}</td>
                                            <td>{{ optional($tx->paid_at)->format('M d, Y') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0"><i class="fas fa-clipboard-check me-2 text-primary"></i>Request Summary</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <div class="p-2 border rounded bg-light d-flex justify-content-between"><span>Total</span><strong>{{ $admissionStats['total'] }}</strong></div>
                        <div class="p-2 border rounded bg-light d-flex justify-content-between"><span>Pending</span><strong>{{ $admissionStats['pending'] }}</strong></div>
                        <div class="p-2 border rounded bg-light d-flex justify-content-between"><span>Approved</span><strong>{{ $admissionStats['approved'] }}</strong></div>
                        <div class="p-2 border rounded bg-light d-flex justify-content-between"><span>Rejected</span><strong>{{ $admissionStats['rejected'] }}</strong></div>
                    </div>
                    <hr>
                    <small class="text-muted">Admission processing usually takes 1-3 working days.</small>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0"><i class="fas fa-pen-to-square me-2 text-primary"></i>Admission Application Form</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('student.admission-request.submit') }}">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Request Type</label>
                                <select name="request_type" class="form-select" required>
                                    <option value="">Select type</option>
                                    <option value="class" {{ old('request_type') === 'class' ? 'selected' : '' }}>Class Admission</option>
                                    <option value="course" {{ old('request_type') === 'course' ? 'selected' : '' }}>Course Enrollment</option>
                                    <option value="both" {{ old('request_type') === 'both' ? 'selected' : '' }}>Class + Course</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Preferred Start Date</label>
                                <input type="date" name="preferred_start_date" class="form-control" value="{{ old('preferred_start_date') }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Requested Class</label>
                                <select name="requested_class" class="form-select">
                                    <option value="">Select class</option>
                                    @foreach($availableClasses as $classOption)
                                        <option value="{{ $classOption }}" {{ old('requested_class') == $classOption ? 'selected' : '' }}>{{ $classOption }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Requested Section</label>
                                <select name="requested_section" class="form-select">
                                    <option value="">Select section</option>
                                    @foreach($availableSections as $sectionOption)
                                        <option value="{{ $sectionOption }}" {{ old('requested_section') == $sectionOption ? 'selected' : '' }}>{{ $sectionOption }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Requested Course</label>
                                <select name="requested_course_id" class="form-select">
                                    <option value="">Select course</option>
                                    @foreach($availableCourses as $course)
                                        <option value="{{ $course->id }}" {{ old('requested_course_id') == $course->id ? 'selected' : '' }}>
                                            {{ $course->title }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Guardian Contact</label>
                                <input type="text" name="guardian_contact" class="form-control" value="{{ old('guardian_contact', $student->emergency_contact) }}" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Reason / Statement</label>
                                <textarea name="reason" rows="4" class="form-control" placeholder="Explain your admission request..." required>{{ old('reason') }}</textarea>
                            </div>
                            <div class="col-12 d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-paper-plane me-1"></i>Submit Application
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0"><i class="fas fa-history me-2 text-success"></i>Admission Request History</h5>
                </div>
                <div class="card-body">
                    @if($admissionRequests->isEmpty())
                        <div class="text-center py-5">
                            <i class="fas fa-inbox fa-2x text-muted mb-2"></i>
                            <p class="text-muted mb-0">No admission request yet.</p>
                        </div>
                    @else
                        <div class="list-group list-group-flush">
                            @foreach($admissionRequests as $req)
                                @php
                                    $statusClass = match($req->status) {
                                        'approved' => 'bg-success',
                                        'rejected' => 'bg-danger',
                                        'in_review' => 'bg-warning text-dark',
                                        default => 'bg-secondary',
                                    };
                                @endphp
                                <div class="list-group-item px-0 py-3">
                                    <div class="d-flex justify-content-between gap-3">
                                        <div>
                                            <h6 class="mb-1 fw-semibold">{{ ucfirst($req->request_type) }} Request</h6>
                                            <small class="text-muted d-block">
                                                {{ $req->requested_class ?? 'N/A' }}{{ $req->requested_section ? ' - ' . $req->requested_section : '' }}
                                            </small>
                                            <small class="text-muted d-block">{{ optional($req->requestedCourse)->title ?? 'N/A' }}</small>
                                            <small class="text-muted">{{ optional($req->submitted_at ?? $req->created_at)->format('M d, Y h:i A') }}</small>
                                        </div>
                                        <span class="badge {{ $statusClass }} align-self-start">{{ ucfirst(str_replace('_', ' ', $req->status)) }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
