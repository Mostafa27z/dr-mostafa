<?php

// app/Models/Exam.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
     protected $fillable = [
        'title','description','start_time','end_time','duration',
        'is_open','is_limited','total_degree','lesson_id','teacher_id','group_id'
    ];
protected $casts = [
        'start_time' => 'datetime',
        'end_time'   => 'datetime',
    ];
    public function questions() {
        return $this->hasMany(ExamQuestion::class);
    }

    public function results() {
        return $this->hasMany(ExamResult::class);
    }
    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }
     public function teacher() {
        return $this->belongsTo(User::class, 'teacher_id');
    }
    public function group()
    {
        return $this->belongsTo(Group::class, 'group_id');
    }
}


