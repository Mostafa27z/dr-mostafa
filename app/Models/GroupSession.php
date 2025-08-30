<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GroupSession extends Model
{
    protected $fillable = ['group_id', 'title', 'description', 'time', 'zoom_link'];

    public function group()
    {
        return $this->belongsTo(Group::class);
    }
}
