<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('grade_scores')) {
            Schema::create('grade_scores', function (Blueprint $table) {
                $table->id();
                $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
                $table->foreignId('course_id')->constrained('courses')->onDelete('cascade');
                $table->foreignId('assignment_id')->nullable()->constrained('assignments')->onDelete('cascade');
                $table->foreignId('exam_id')->nullable()->constrained('exams')->onDelete('cascade');
                $table->decimal('marks_obtained', 5, 2);
                $table->decimal('total_marks', 5, 2);
                $table->decimal('percentage', 5, 2);
                $table->string('grade')->nullable();
                $table->text('remarks')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('grade_scores');
    }
};
