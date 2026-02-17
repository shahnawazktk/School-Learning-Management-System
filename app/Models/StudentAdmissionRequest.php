<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentAdmissionRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'request_type',
        'requested_class',
        'requested_section',
        'requested_course_id',
        'preferred_start_date',
        'guardian_contact',
        'reason',
        'status',
        'admin_notes',
        'submitted_at',
        'reviewed_at',
    ];

    protected $casts = [
        'preferred_start_date' => 'date',
        'submitted_at' => 'datetime',
        'reviewed_at' => 'datetime',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function requestedCourse()
    {
        return $this->belongsTo(Course::class, 'requested_course_id');
    }
}
