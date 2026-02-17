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
        if (!Schema::hasTable('fee_payments')) {
            Schema::create('fee_payments', function (Blueprint $table) {
                $table->id();
                $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
                $table->string('title');
                $table->text('description')->nullable();
                $table->decimal('amount', 10, 2);
                $table->decimal('paid_amount', 10, 2)->default(0);
                $table->date('due_date')->nullable();
                $table->timestamp('paid_at')->nullable();
                $table->enum('status', ['unpaid', 'partial', 'paid', 'overdue'])->default('unpaid');
                $table->string('payment_method')->nullable();
                $table->string('receipt_number')->nullable();
                $table->text('remarks')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fee_payments');
    }
};
