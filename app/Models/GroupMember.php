<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GroupMember extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable
     */
    protected $fillable = [
        'group_id',
        'student_id',
        'status' // pending | approved | rejected
    ];

    /**
     * The attributes that should be cast
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * ==================== RELATIONSHIPS ====================
     */

    /**
     * Get the group this member belongs to
     */
    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    /**
     * Get the student (user) who is a member
     */
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    /**
     * ==================== SCOPES ====================
     */

    /**
     * Scope to get approved members only
     */
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    /**
     * Scope to get pending requests only
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope to get rejected members
     */
    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    /**
     * ==================== HELPER METHODS ====================
     */

    /**
     * Check if member is approved
     */
    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }

    /**
     * Check if member is pending
     */
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    /**
     * Check if member is rejected
     */
    public function isRejected(): bool
    {
        return $this->status === 'rejected';
    }

    /**
     * Get human-readable status label
     */
    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'approved' => 'موافق عليه',
            'pending' => 'قيد الانتظار',
            'rejected' => 'مرفوض',
            default => 'غير معروف'
        };
    }
}