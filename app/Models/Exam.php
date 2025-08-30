<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    protected $fillable = ['course_id','title','description','start_time','end_time','duration'];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function questions()
    {
        return $this->hasMany(ExamQuestion::class);
    }

    public function results()
    {
        return $this->hasMany(ExamResult::class);
    }
}

