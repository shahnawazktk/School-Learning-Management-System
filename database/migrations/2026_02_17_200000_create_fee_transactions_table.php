<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('fee_transactions')) {
            Schema::create('fee_transactions', function (Blueprint $table) {
                $table->id();
                $table->foreignId('fee_payment_id')->constrained('fee_payments')->onDelete('cascade');
                $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
                $table->decimal('amount', 10, 2);
                $table->enum('payment_method', ['easypaisa', 'jazzcash', 'bank_transfer']);
                $table->string('transaction_id');
                $table->string('payer_account')->nullable();
                $table->string('proof_path')->nullable();
                $table->text('notes')->nullable();
                $table->string('receipt_number')->unique();
                $table->timestamp('paid_at');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fee_transactions');
    }
};
