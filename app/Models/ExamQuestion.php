<?php

// app/Models/ExamQuestion.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class ExamQuestion extends Model
{
    use HasFactory;
    protected $fillable = ['exam_id','title','degree'];

    public function exam() {
        return $this->belongsTo(Exam::class);
    }

    public function options() {
        return $this->hasMany(ExamQuestionOption::class);
    }

    public function answers() {
        return $this->hasMany(ExamAnswer::class);
    }
}
