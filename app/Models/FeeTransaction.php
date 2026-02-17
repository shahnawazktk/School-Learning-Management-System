<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeeTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'fee_payment_id',
        'student_id',
        'amount',
        'payment_method',
        'transaction_id',
        'payer_account',
        'proof_path',
        'notes',
        'receipt_number',
        'paid_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'paid_at' => 'datetime',
    ];

    public function feePayment()
    {
        return $this->belongsTo(FeePayment::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
