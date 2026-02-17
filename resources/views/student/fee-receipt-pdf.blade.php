<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Fee Receipt</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; color: #222; font-size: 12px; }
        .container { padding: 20px; }
        .header { margin-bottom: 20px; }
        .title { font-size: 22px; font-weight: bold; margin-bottom: 4px; }
        .muted { color: #666; }
        .card { border: 1px solid #ddd; border-radius: 6px; padding: 14px; margin-bottom: 12px; }
        .row { width: 100%; margin-bottom: 8px; }
        .label { display: inline-block; width: 160px; font-weight: bold; }
        .amount-box { margin-top: 10px; padding-top: 8px; border-top: 1px solid #ddd; font-size: 14px; font-weight: bold; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="title">Fee Payment Receipt</div>
            <div class="muted">Receipt No: {{ $transaction->receipt_number }}</div>
        </div>

        <div class="card">
            <div class="row"><span class="label">Student Name:</span> {{ auth()->user()->name }}</div>
            <div class="row"><span class="label">Student ID:</span> {{ $student->student_id ?? 'N/A' }}</div>
            <div class="row"><span class="label">Class:</span> {{ $student->class ?? 'N/A' }} - {{ $student->section ?? 'N/A' }}</div>
        </div>

        <div class="card">
            <div class="row"><span class="label">Fee Bill:</span> {{ $fee->title }}</div>
            <div class="row"><span class="label">Payment Date:</span> {{ optional($transaction->paid_at)->format('M d, Y h:i A') }}</div>
            <div class="row"><span class="label">Method:</span> {{ ucfirst(str_replace('_', ' ', $transaction->payment_method)) }}</div>
            <div class="row"><span class="label">Transaction ID:</span> {{ $transaction->transaction_id }}</div>
            @if($transaction->payer_account)
                <div class="row"><span class="label">Payer Account:</span> {{ $transaction->payer_account }}</div>
            @endif
            <div class="amount-box">Paid Amount: Rs. {{ number_format((float) $transaction->amount, 2) }}</div>
        </div>

        @if($transaction->notes)
            <div class="card">
                <div class="row"><span class="label">Notes:</span> {{ $transaction->notes }}</div>
            </div>
        @endif
    </div>
</body>
</html>
