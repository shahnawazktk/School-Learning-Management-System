<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $fillable = [
        'user_id',
        'teacher_id',
        'department',
        'qualification',
        'experience',
        'joining_date',
        'date_of_birth',
        'gender',
        'address',
        'city',
        'state',
        'zip_code',
        'country',
        'emergency_contact',
        'profile_image',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function courses()
    {
        return $this->hasMany(Course::class);
    }

    public function assignments()
    {
        return $this->hasMany(Assignment::class);
    }

    public function exams()
    {
        return $this->hasMany(Exam::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function submissions()
    {
        return $this->hasManyThrough(Submission::class, Assignment::class);
    }
}
