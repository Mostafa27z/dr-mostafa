<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExamQuestion extends Model
{
    protected $fillable = ['exam_id','question_text','type','marks'];

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    public function options()
    {
        return $this->hasMany(ExamQuestionOption::class);
    }

    public function answers()
    {
        return $this->hasMany(StudentAnswer::class);
    }
}
