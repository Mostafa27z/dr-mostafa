<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;

class Group extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable
     */
    protected $fillable = [
        'title',
        'description',
        'image',
        'price',
        'teacher_id'
    ];

    /**
     * The attributes that should be cast
     */
    protected $casts = [
        'price' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime'
    ];

    /**
     * The accessors to append to model's array form
     */
    protected $appends = [
        'image_url',
        'formatted_price'
    ];

    /**
     * ==================== RELATIONSHIPS ====================
     */

    /**
     * Get the teacher that owns the group
     */
    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    /**
     * Get all group members (pivot records)
     */
    public function members()
    {
        return $this->hasMany(GroupMember::class);
    }

    /**
     * Get approved students only
     */
    public function students()
    {
        return $this->belongsToMany(
            User::class,
            'group_members',
            'group_id',
            'student_id'
        )
        ->withPivot('status')
        ->wherePivot('status', 'approved');
    }

    /**
     * Get pending join requests
     */
    public function pendingRequests()
    {
        return $this->hasMany(GroupMember::class)
            ->where('status', 'pending');
    }

    /**
     * Get group sessions
     */
    public function sessions()
    {
        return $this->hasMany(GroupSession::class);
    }

    /**
     * Get group assignments
     */
    public function assignments()
    {
        return $this->hasMany(Assignment::class);
    }

    /**
     * ==================== ACCESSORS ====================
     */

    /**
     * Get the full URL to the group image
     * Uses Storage::url() which respects APP_URL configuration
     */
    public function getImageUrlAttribute(): ?string
    {
        if (!$this->image) {
            return asset('images/default-group.png');
        }

        // This respects APP_URL from .env file
        return Storage::url($this->image);
    }

    /**
     * Get formatted price with currency
     */
    public function getFormattedPriceAttribute(): string
    {
        if ($this->price > 0) {
            return number_format($this->price, 2) . ' ج.م';
        }

        return 'مجاني';
    }

    /**
     * ==================== HELPER METHODS ====================
     */

    /**
     * Check if a student is an approved member
     */
    public function hasMember($studentId): bool
    {
        return $this->members()
            ->where('student_id', $studentId)
            ->where('status', 'approved')
            ->exists();
    }

    /**
     * Check if a student has a pending join request
     */
    public function hasPendingRequest($studentId): bool
    {
        return $this->members()
            ->where('student_id', $studentId)
            ->where('status', 'pending')
            ->exists();
    }

    /**
     * Get member status (approved, pending, rejected)
     */
    public function getMemberStatus($studentId): ?string
    {
        return $this->members()
            ->where('student_id', $studentId)
            ->first()?->status;
    }

    /**
     * Get total revenue from this group
     */
    public function getTotalRevenue(): int|float
    {
        return $this->students()->count() * $this->price;
    }

    /**
     * Get approved members count
     */
    public function getApprovedMembersCount(): int
    {
        return $this->members()
            ->where('status', 'approved')
            ->count();
    }

    /**
     * Get pending requests count
     */
    public function getPendingRequestsCount(): int
    {
        return $this->members()
            ->where('status', 'pending')
            ->count();
    }

    /**
     * ==================== SCOPES ====================
     */

    /**
     * Scope to filter groups by teacher
     */
    public function scopeByTeacher($query, $teacherId)
    {
        return $query->where('teacher_id', $teacherId);
    }

    /**
     * Scope to search groups
     */
    public function scopeSearch($query, $searchTerm)
    {
        return $query->where(function ($q) use ($searchTerm) {
            $q->where('title', 'like', "%{$searchTerm}%")
              ->orWhere('description', 'like', "%{$searchTerm}%");
        });
    }

    /**
     * Scope to get active groups only
     */
    public function scopeActive($query)
    {
        return $query->whereNotNull('teacher_id');
    }

    /**
     * ==================== EVENTS ====================
     */

    /**
     * Boot method - handles model events
     * Deletes the image file when a group is deleted
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($group) {
            if ($group->image && Storage::exists($group->image)) {
                Storage::delete($group->image);
            }
        });

        static::forceDeleted(function ($group) {
            if ($group->image && Storage::exists($group->image)) {
                Storage::delete($group->image);
            }
        });
    }
}