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
        Schema::table('enrollments', function (Blueprint $table) {
            if (!Schema::hasColumn('enrollments', 'student_id')) {
                $table->unsignedBigInteger('student_id')->nullable()->index();
            }

            if (!Schema::hasColumn('enrollments', 'course_id')) {
                $table->unsignedBigInteger('course_id')->nullable()->index();
            }

            if (!Schema::hasColumn('enrollments', 'subject_id')) {
                $table->unsignedBigInteger('subject_id')->nullable()->index();
            }

            if (!Schema::hasColumn('enrollments', 'enrollment_date')) {
                $table->date('enrollment_date')->nullable();
            }

            if (!Schema::hasColumn('enrollments', 'status')) {
                $table->enum('status', ['enrolled', 'completed', 'dropped'])->default('enrolled');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('enrollments', function (Blueprint $table) {
            if (Schema::hasColumn('enrollments', 'status')) {
                $table->dropColumn('status');
            }

            if (Schema::hasColumn('enrollments', 'enrollment_date')) {
                $table->dropColumn('enrollment_date');
            }

            if (Schema::hasColumn('enrollments', 'subject_id')) {
                $table->dropColumn('subject_id');
            }

            if (Schema::hasColumn('enrollments', 'course_id')) {
                $table->dropColumn('course_id');
            }

            if (Schema::hasColumn('enrollments', 'student_id')) {
                $table->dropColumn('student_id');
            }
        });
    }
};
