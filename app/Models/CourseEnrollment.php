<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseEnrollment extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'student_id',
        'status',
        'enrolled_at',
        'completed_at',
        'paid_amount',
        'payment_method',
        'transaction_id',
        'notes',
    ];

    protected $casts = [
        'enrolled_at' => 'datetime',
        'completed_at' => 'datetime',
        'paid_amount' => 'decimal:2',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }
    public function lessons()
    {
        return $this->hasManyThrough(
            Lesson::class,   // الموديل النهائي
            Course::class,   // الموديل الوسيط
            'id',            // مفتاح الكورس في جدول الكورسات
            'course_id',     // المفتاح الأجنبي في جدول الدروس
            'course_id',     // المفتاح في جدول الإنرولمنت
            'id'             // المفتاح الأساسي للكورس
        );
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function approve()
    {
        $this->update([
            'status' => 'approved',
            'enrolled_at' => now()
        ]);
    }

    public function reject()
    {
        $this->update(['status' => 'rejected']);
    }

    public function complete()
    {
        $this->update([
            'status' => 'completed',
            'completed_at' => now()
        ]);
    }
}