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
        'video_name',
        'video_size',
        'video_duration',
        'files',
        'course_id',
        'order',
        'is_free',
        'status',
        'published_at',
    ];

    protected $casts = [
        'files' => 'array',
        'is_free' => 'boolean',
        'published_at' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */
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

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    // رابط الفيديو
    public function getVideoUrlAttribute()
    {
        return $this->video ? asset('storage/' . $this->video) : null;
    }

    // روابط الملفات
    public function getFileUrlsAttribute()
    {
        if (!is_array($this->files)) {
            return [];
        }

        return array_map(function ($file) {
            return [
                'original_name' => $file['original_name'] ?? null,
                'stored_name'   => $file['stored_name'] ?? null,
                'url'           => isset($file['path']) ? asset('storage/' . $file['path']) : null,
                'size'          => $file['size'] ?? null,
                'type'          => $file['type'] ?? null,
                'extension'     => $file['extension'] ?? null,
                'uploaded_at'   => $file['uploaded_at'] ?? null,
            ];
        }, $this->files);
    }
}
