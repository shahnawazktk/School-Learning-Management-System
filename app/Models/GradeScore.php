<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GradeScore extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'course_id',
        'assignment_id',
        'exam_id',
        'marks_obtained',
        'total_marks',
        'percentage',
        'grade',
        'remarks',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function assignment()
    {
        return $this->belongsTo(Assignment::class);
    }

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }
}
