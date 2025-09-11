<?php

// app/Models/ExamAnswer.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExamAnswer extends Model
{
    protected $fillable = [
        'student_id','exam_question_id','exam_question_option_id',
        'correct_option_id','degree'
    ];

    public function question() {
    return $this->belongsTo(ExamQuestion::class, 'exam_question_id');
}


    public function chosenOption() {
        return $this->belongsTo(ExamQuestionOption::class, 'exam_question_option_id');
    }

    public function correctOption() {
        return $this->belongsTo(ExamQuestionOption::class, 'correct_option_id');
    }

    public function student() {
        return $this->belongsTo(User::class, 'student_id');
    }
}

