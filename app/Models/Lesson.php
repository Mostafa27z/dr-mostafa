<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'video',
        'files',
        'course_id',
    ];

    protected $casts = [
        'files' => 'array',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function assignments()
    {
        return $this->hasMany(Assignment::class);
    }

    public function exams()
    {
        return $this->hasMany(Exam::class);
    }

    public function getFilesAttribute($value)
    {
        return $value ? json_decode($value, true) : [];
    }

    public function setFilesAttribute($value)
    {
        $this->attributes['files'] = is_array($value) ? json_encode($value) : $value;
    }

    public function getVideoUrlAttribute()
    {
        return $this->video ? asset('storage/' . $this->video) : null;
    }

    public function getFileUrlsAttribute()
    {
        $files = $this->files;
        if (!is_array($files)) return [];
        
        return array_map(function($file) {
            return [
                'name' => $file['name'],
                'url' => asset('storage/' . $file['path']),
                'size' => $file['size'],
                'type' => $file['type']
            ];
        }, $files);
    }
}