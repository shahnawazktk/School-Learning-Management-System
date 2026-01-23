<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = [
        // Add fields based on migration if any
    ];

    public function courses()
    {
        return $this->hasMany(Course::class);
    }
}
