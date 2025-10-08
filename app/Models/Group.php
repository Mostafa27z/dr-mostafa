<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Group extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'image',
        'price',
        'teacher_id'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime'
    ];

    protected $appends = [
        'image_url',
        'formatted_price'
    ];

    /** Teacher */
    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    /** All group members (pivot records) */
    public function members()
    {
        return $this->hasMany(GroupMember::class);
    }

    /** Approved students (User models) */
    public function students()
    {
        return $this->belongsToMany(User::class, 'group_members', 'group_id', 'student_id')
                    ->withPivot('status')
                    ->wherePivot('status', 'approved');
    }

    /** Pending join requests */
    public function pendingRequests()
    {
        return $this->hasMany(GroupMember::class)->where('status', 'pending');
    }

    /** Sessions */
    public function sessions()
    {
        return $this->hasMany(GroupSession::class);
    }

    /** Assignments */
    public function assignments()
    {
        return $this->hasMany(Assignment::class);
    }

    /** Image URL accessor */
    public function getImageUrlAttribute()
    {
        return $this->image
            ? Storage::disk('public')->url($this->image)
            : asset('images/default-group.png');
    }

    /** Price formatting */
    public function getFormattedPriceAttribute()
    {
        return $this->price > 0
            ? number_format($this->price, 2) . ' جنيه'
            : 'مجاني';
    }

    /** Check membership */
    public function hasMember($studentId)
    {
        return $this->members()
            ->where('student_id', $studentId)
            ->where('status', 'approved')
            ->exists();
    }

    /** Check pending request */
    public function hasPendingRequest($studentId)
    {
        return $this->members()
            ->where('student_id', $studentId)
            ->where('status', 'pending')
            ->exists();
    }

    /** Get member status */
    public function getMemberStatus($studentId)
    {
        $member = $this->members()
            ->where('student_id', $studentId)
            ->first();

        return $member?->status;
    }

    /** Scope filter by teacher */
    public function scopeByTeacher($query, $teacherId)
    {
        return $query->where('teacher_id', $teacherId);
    }

    /** Scope search */
    public function scopeSearch($query, $searchTerm)
    {
        return $query->where(function ($q) use ($searchTerm) {
            $q->where('title', 'like', "%{$searchTerm}%")
              ->orWhere('description', 'like', "%{$searchTerm}%");
        });
    }

    /** Total revenue */
    public function getTotalRevenue()
    {
        return $this->students()->count() * $this->price;
    }

    /** Boot (delete image on group delete) */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($group) {
            if ($group->image) {
                Storage::disk('public')->delete($group->image);
            }
        });
    }
}
