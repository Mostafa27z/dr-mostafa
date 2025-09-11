<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'image',
        'price',
        'teacher_id',
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    // public function lessons()
    // {
    //     return $this->hasMany(Lesson::class);
    // }
     public function lessons()
    {
        return $this->hasMany(Lesson::class, 'course_id');
    }
    public function enrollments()
    {
        return $this->hasMany(CourseEnrollment::class);
    }

    public function students()
    {
        return $this->belongsToMany(User::class, 'course_enrollments', 'course_id', 'student_id')
                    ->withPivot('status', 'enrolled_at', 'completed_at', 'paid_amount')
                    ->withTimestamps();
    }

    public function getImageUrlAttribute()
    {
        return $this->image ? asset('storage/' . $this->image) : null;
    }

    public function getFormattedPriceAttribute()
    {
        return number_format($this->price, 2) . ' جنيه';
    }

    public function getTotalLessonsAttribute()
    {
        return $this->lessons()->count();
    }

    public function getTotalStudentsAttribute()
    {
        return $this->enrollments()->where('status', 'approved')->count();
    }

    public function getPendingEnrollmentsAttribute()
    {
        return $this->enrollments()->where('status', 'pending')->count();
    }
}