@extends('layouts.student.app')

@section('content')
<div class="container-fluid p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1"><i class="fas fa-file-invoice-dollar text-primary me-2"></i>Payment Receipt</h4>
            <p class="text-muted mb-0">Receipt No: {{ $transaction->receipt_number }}</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('student.fees') }}" class="btn btn-outline-secondary">Back</a>
            <a href="{{ route('student.fees.receipt.download', $transaction->id) }}" class="btn btn-primary">Download PDF</a>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <div class="row g-4">
                <div class="col-md-6">
                    <h6 class="text-muted mb-2">Student Details</h6>
                    <div><strong>Name:</strong> {{ auth()->user()->name }}</div>
                    <div><strong>Student ID:</strong> {{ $student->student_id ?? 'N/A' }}</div>
                    <div><strong>Class:</strong> {{ $student->class ?? 'N/A' }} - {{ $student->section ?? 'N/A' }}</div>
                </div>
                <div class="col-md-6">
                    <h6 class="text-muted mb-2">Payment Details</h6>
                    <div><strong>Receipt No:</strong> {{ $transaction->receipt_number }}</div>
                    <div><strong>Date:</strong> {{ optional($transaction->paid_at)->format('M d, Y h:i A') }}</div>
                    <div><strong>Method:</strong> {{ ucfirst(str_replace('_', ' ', $transaction->payment_method)) }}</div>
                    <div><strong>Transaction ID:</strong> {{ $transaction->transaction_id }}</div>
                </div>
                <div class="col-12">
                    <hr>
                    <h6 class="text-muted mb-3">Fee Bill</h6>
                    <div class="d-flex justify-content-between mb-2">
                        <span>{{ $fee->title }}</span>
                        <span>Rs. {{ number_format((float) $transaction->amount, 2) }}</span>
                    </div>
                    @if($transaction->notes)
                        <div class="mt-3">
                            <strong>Notes:</strong> {{ $transaction->notes }}
                        </div>
                    @endif
                    @if($transaction->proof_path)
                        <div class="mt-2">
                            <strong>Proof:</strong>
                            <a href="{{ asset('storage/' . $transaction->proof_path) }}" target="_blank">View uploaded proof</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
