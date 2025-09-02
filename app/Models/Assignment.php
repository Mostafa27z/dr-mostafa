<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'files',
        'deadline',
        'is_open',
        'total_mark',
        'group_id',
        'lesson_id',
    ];

    protected $casts = [
        'files' => 'array', // نخزن الملفات كـ JSON
        'is_open' => 'boolean',
        'deadline' => 'datetime',
    ];

    public function group() {
        return $this->belongsTo(Group::class);
    }

    public function lesson() {
        return $this->belongsTo(Lesson::class);
    }

    public function answers() {
        return $this->hasMany(AssignmentAnswer::class);
    }
}
