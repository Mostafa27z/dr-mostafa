<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignmentAnswer extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'assignment_id',
        'answer_file',
        'answer_text',
        'teacher_comment',
        'teacher_degree',
        'teacher_file',
    ];

    public function student() {
        return $this->belongsTo(User::class, 'student_id'); // لو عندك موديل Student منفصل غيّرها
    }

    public function assignment() {
        return $this->belongsTo(Assignment::class);
    }
}
