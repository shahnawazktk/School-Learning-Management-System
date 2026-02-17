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
        if (!Schema::hasTable('student_admission_requests')) {
            Schema::create('student_admission_requests', function (Blueprint $table) {
                $table->id();
                $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
                $table->enum('request_type', ['class', 'course', 'both'])->default('course');
                $table->string('requested_class')->nullable();
                $table->string('requested_section')->nullable();
                $table->foreignId('requested_course_id')->nullable()->constrained('courses')->nullOnDelete();
                $table->date('preferred_start_date')->nullable();
                $table->string('guardian_contact', 100);
                $table->text('reason');
                $table->enum('status', ['pending', 'in_review', 'approved', 'rejected'])->default('pending');
                $table->text('admin_notes')->nullable();
                $table->timestamp('submitted_at')->nullable();
                $table->timestamp('reviewed_at')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_admission_requests');
    }
};
