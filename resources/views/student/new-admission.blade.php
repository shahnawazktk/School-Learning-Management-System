@extends('layouts.student.app')

@section('content')
<div class="container-fluid p-4">
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Form submit nahi hua.</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
        <div>
            <h4 class="mb-1"><i class="fas fa-plus-circle text-primary me-2"></i>New Admission</h4>
            <p class="text-muted mb-0">Student profile, fee summary, aur new admission application form.</p>
        </div>
        <a href="{{ route('student.admission-request') }}" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-arrow-left me-1"></i>Back to Admission Portal
        </a>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0"><i class="fas fa-money-check-dollar me-2 text-success"></i>Fee Payment Detail</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-3 col-6">
                            <div class="p-2 border rounded bg-light">
                                <small class="text-muted d-block">Total</small>
                                <strong>Rs. {{ number_format($feeStats['total_amount'], 2) }}</strong>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="p-2 border rounded bg-light">
                                <small class="text-muted d-block">Paid</small>
                                <strong class="text-success">Rs. {{ number_format($feeStats['paid_amount'], 2) }}</strong>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="p-2 border rounded bg-light">
                                <small class="text-muted d-block">Outstanding</small>
                                <strong class="text-danger">Rs. {{ number_format($feeStats['outstanding_amount'], 2) }}</strong>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="p-2 border rounded bg-light">
                                <small class="text-muted d-block">Pending Bills</small>
                                <strong>{{ $feeStats['pending_count'] }}</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0"><i class="fas fa-user-pen me-2 text-primary"></i>Editable Student Details</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('student.new-admission.profile.update') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="text-center mb-3">
                            @if(!empty($student->profile_image))
                                <img src="{{ asset('storage/' . $student->profile_image) }}" alt="Student Profile" class="rounded-circle mb-2" style="width: 96px; height: 96px; object-fit: cover;">
                            @else
                                <div class="rounded-circle bg-primary-subtle text-primary d-inline-flex align-items-center justify-content-center mb-2" style="width: 96px; height: 96px; font-size: 30px; font-weight: 700;">
                                    {{ strtoupper(substr((string) auth()->user()->name, 0, 2)) }}
                                </div>
                            @endif
                            <div class="small text-muted">{{ auth()->user()->name }} ({{ $student->student_id ?? 'N/A' }})</div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Profile Image</label>
                            <input type="file" name="profile_image" class="form-control" accept=".jpg,.jpeg,.png,.webp">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Emergency Contact</label>
                            <input type="text" name="emergency_contact" class="form-control" value="{{ old('emergency_contact', $student->emergency_contact) }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Address</label>
                            <input type="text" name="address" class="form-control" value="{{ old('address', $student->address) }}">
                        </div>
                        <div class="row g-2">
                            <div class="col-6">
                                <label class="form-label">City</label>
                                <input type="text" name="city" class="form-control" value="{{ old('city', $student->city) }}">
                            </div>
                            <div class="col-6">
                                <label class="form-label">State</label>
                                <input type="text" name="state" class="form-control" value="{{ old('state', $student->state) }}">
                            </div>
                        </div>
                        <div class="mt-3">
                            <label class="form-label">ZIP Code</label>
                            <input type="text" name="zip_code" class="form-control" value="{{ old('zip_code', $student->zip_code) }}">
                        </div>
                        <div class="d-grid mt-3">
                            <button type="submit" class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-save me-1"></i>Save Student Details
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-bottom">
            <h5 class="mb-0"><i class="fas fa-pen-to-square me-2 text-primary"></i>Admission Form</h5>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('student.admission-request.submit') }}">
                @csrf
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Request Type</label>
                        <select name="request_type" class="form-select" required>
                            <option value="">Select type</option>
                            <option value="class" {{ old('request_type') === 'class' ? 'selected' : '' }}>Class Admission</option>
                            <option value="course" {{ old('request_type') === 'course' ? 'selected' : '' }}>Course Enrollment</option>
                            <option value="both" {{ old('request_type') === 'both' ? 'selected' : '' }}>Class + Course</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Requested Class</label>
                        <select name="requested_class" class="form-select">
                            <option value="">Select class</option>
                            @foreach($availableClasses as $classOption)
                                <option value="{{ $classOption }}" {{ old('requested_class') == $classOption ? 'selected' : '' }}>{{ $classOption }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Requested Section</label>
                        <select name="requested_section" class="form-select">
                            <option value="">Select section</option>
                            @foreach($availableSections as $sectionOption)
                                <option value="{{ $sectionOption }}" {{ old('requested_section') == $sectionOption ? 'selected' : '' }}>{{ $sectionOption }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Requested Course</label>
                        <select name="requested_course_id" class="form-select">
                            <option value="">Select course</option>
                            @foreach($availableCourses as $course)
                                <option value="{{ $course->id }}" {{ old('requested_course_id') == $course->id ? 'selected' : '' }}>{{ $course->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Preferred Start Date</label>
                        <input type="date" name="preferred_start_date" class="form-control" value="{{ old('preferred_start_date') }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Guardian Contact</label>
                        <input type="text" name="guardian_contact" class="form-control" value="{{ old('guardian_contact', $student->emergency_contact) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Student Email</label>
                        <input type="text" class="form-control" value="{{ auth()->user()->email }}" readonly>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Reason / Statement</label>
                        <textarea name="reason" rows="4" class="form-control" placeholder="Explain your admission request..." required>{{ old('reason') }}</textarea>
                    </div>
                    <div class="col-12 d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-paper-plane me-1"></i>Submit New Admission
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
