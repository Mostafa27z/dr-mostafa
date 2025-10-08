<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class GroupMember extends Model
{
    use HasFactory;
    protected $fillable = ['group_id', 'student_id', 'status']; // pending | approved

    public $timestamps = false; // لو جدول group_members مفيهوش created_at و updated_at

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }
}
