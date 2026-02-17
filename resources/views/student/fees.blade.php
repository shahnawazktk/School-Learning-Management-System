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
            <strong>Payment submit nahi hua.</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">
        <div>
            <h4 class="mb-1"><i class="fas fa-money-bill-wave text-primary me-2"></i>Fee Management</h4>
            <p class="text-muted mb-0">Online payment (EasyPaisa, JazzCash, Bank) aur receipt download dono available hain.</p>
        </div>
        <form method="GET" action="{{ route('student.fees') }}" class="d-flex gap-2">
            <select name="status" class="form-select">
                <option value="" {{ $status === '' ? 'selected' : '' }}>All Status</option>
                <option value="unpaid" {{ $status === 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                <option value="partial" {{ $status === 'partial' ? 'selected' : '' }}>Partially Paid</option>
                <option value="paid" {{ $status === 'paid' ? 'selected' : '' }}>Paid</option>
                <option value="overdue" {{ $status === 'overdue' ? 'selected' : '' }}>Overdue</option>
            </select>
            <button type="submit" class="btn btn-primary">Filter</button>
        </form>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-3 col-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <small class="text-muted d-block mb-2">Total Fee</small>
                    <h5 class="fw-bold mb-0">Rs. {{ number_format($stats['total_amount'], 2) }}</h5>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <small class="text-muted d-block mb-2">Paid</small>
                    <h5 class="fw-bold text-success mb-0">Rs. {{ number_format($stats['paid_amount'], 2) }}</h5>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <small class="text-muted d-block mb-2">Outstanding</small>
                    <h5 class="fw-bold text-danger mb-0">Rs. {{ number_format($stats['outstanding_amount'], 2) }}</h5>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <small class="text-muted d-block mb-2">Pending Bills</small>
                    <h5 class="fw-bold mb-0">{{ $stats['pending_count'] }}</h5>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white border-bottom">
            <h5 class="mb-0">Payment Channels</h5>
        </div>
        <div class="card-body">
            <div class="row g-3">
                @foreach($paymentChannels as $channel)
                    <div class="col-md-4">
                        <div class="border rounded-3 p-3 h-100">
                            <div class="fw-semibold mb-2">
                                <i class="{{ $channel['icon'] }} me-2 {{ $channel['icon_color'] }}"></i>{{ $channel['label'] }}
                            </div>
                            @if(!empty($channel['line1']))
                                <small class="text-muted d-block">{{ $channel['line1'] }}</small>
                            @endif
                            @if(!empty($channel['line2']))
                                <small class="text-muted d-block">{{ $channel['line2'] }}</small>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white border-bottom">
            <h5 class="mb-0">Fee Bills</h5>
        </div>
        <div class="card-body p-0">
            @if($fees->isEmpty())
                <div class="text-center py-5">
                    <i class="fas fa-receipt fa-3x text-muted mb-3"></i>
                    <p class="text-muted mb-0">No fee records found.</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Title</th>
                                <th>Due Date</th>
                                <th>Total</th>
                                <th>Paid</th>
                                <th>Remaining</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($fees as $fee)
                                @php
                                    $remaining = max((float) $fee->amount - (float) $fee->paid_amount, 0);
                                    $statusClass = match($fee->status) {
                                        'paid' => 'bg-success',
                                        'partial' => 'bg-warning text-dark',
                                        'overdue' => 'bg-danger',
                                        default => 'bg-secondary',
                                    };
                                @endphp
                                <tr>
                                    <td>
                                        <div class="fw-semibold">{{ $fee->title }}</div>
                                        @if($fee->description)
                                            <small class="text-muted">{{ $fee->description }}</small>
                                        @endif
                                    </td>
                                    <td>{{ optional($fee->due_date)->format('M d, Y') ?? 'N/A' }}</td>
                                    <td>Rs. {{ number_format((float) $fee->amount, 2) }}</td>
                                    <td>Rs. {{ number_format((float) $fee->paid_amount, 2) }}</td>
                                    <td>Rs. {{ number_format($remaining, 2) }}</td>
                                    <td><span class="badge {{ $statusClass }}">{{ ucfirst($fee->status) }}</span></td>
                                    <td>
                                        @if($remaining > 0)
                                            <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#payFeeModal{{ $fee->id }}">
                                                Pay Now
                                            </button>
                                        @else
                                            <span class="badge bg-success">Settled</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-bottom">
            <h5 class="mb-0">Payment Receipts</h5>
        </div>
        <div class="card-body p-0">
            @if($transactions->isEmpty())
                <div class="text-center py-5">
                    <i class="fas fa-file-invoice-dollar fa-3x text-muted mb-3"></i>
                    <p class="text-muted mb-0">No payments yet.</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Receipt No</th>
                                <th>Bill</th>
                                <th>Method</th>
                                <th>Transaction ID</th>
                                <th>Amount</th>
                                <th>Date</th>
                                <th>Receipt</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transactions as $tx)
                                <tr>
                                    <td>{{ $tx->receipt_number }}</td>
                                    <td>{{ optional($tx->feePayment)->title ?? 'N/A' }}</td>
                                    <td>{{ $paymentMethods[$tx->payment_method] ?? ucfirst(str_replace('_', ' ', $tx->payment_method)) }}</td>
                                    <td>{{ $tx->transaction_id }}</td>
                                    <td>Rs. {{ number_format((float) $tx->amount, 2) }}</td>
                                    <td>{{ optional($tx->paid_at)->format('M d, Y h:i A') }}</td>
                                    <td>
                                        <a href="{{ route('student.fees.receipt', $tx->id) }}" class="btn btn-sm btn-outline-primary">View</a>
                                        <a href="{{ route('student.fees.receipt.download', $tx->id) }}" class="btn btn-sm btn-outline-secondary">Download</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>

@foreach($fees as $fee)
    @php
        $remaining = max((float) $fee->amount - (float) $fee->paid_amount, 0);
    @endphp
    @if($remaining > 0)
        <div class="modal fade" id="payFeeModal{{ $fee->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Pay Fee: {{ $fee->title }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form method="POST" action="{{ route('student.fees.pay', $fee->id) }}" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Remaining Amount</label>
                                    <input type="text" class="form-control" value="Rs. {{ number_format($remaining, 2) }}" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Pay Amount</label>
                                    <input type="number" name="amount" class="form-control" min="1" max="{{ $remaining }}" step="0.01" value="{{ $remaining }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Payment Method</label>
                                    <select name="payment_method" class="form-select" required>
                                        <option value="">Select method</option>
                                        @foreach($paymentMethods as $methodKey => $methodLabel)
                                            <option value="{{ $methodKey }}">{{ $methodLabel }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Transaction / Reference ID</label>
                                    <input type="text" name="transaction_id" class="form-control" placeholder="e.g. EP123456789" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Payer Account (optional)</label>
                                    <input type="text" name="payer_account" class="form-control" placeholder="03XX-XXXXXXX or Bank Acc">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Payment Proof (optional)</label>
                                    <input type="file" name="payment_proof" class="form-control" accept=".jpg,.jpeg,.png,.pdf">
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Notes (optional)</label>
                                    <textarea name="notes" class="form-control" rows="3" placeholder="Any remarks..."></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Submit Payment</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
@endforeach
@endsection
