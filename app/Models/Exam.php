<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'course_id',
        'exam_date',
        'start_time',
        'end_time',
        'total_marks',
        'type',
        'status',
    ];

    protected $casts = [
        'exam_date' => 'date',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function gradeScores()
    {
        return $this->hasMany(GradeScore::class);
    }
}
