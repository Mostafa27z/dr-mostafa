<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $fillable = ['name', 'teacher_id'];

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function members()
    {
        return $this->hasMany(GroupMember::class);
    }

    public function sessions()
    {
        return $this->hasMany(GroupSession::class);
    }
}
