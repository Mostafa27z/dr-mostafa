<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('lessons', function (Blueprint $table) {
            // Video metadata fields
            $table->string('video_name')->nullable()->after('video');
            $table->bigInteger('video_size')->nullable()->after('video_name');
            $table->integer('video_duration')->nullable()->after('video_size'); // duration in seconds
            
            // Lesson management fields
            $table->foreignId('teacher_id')->nullable()->constrained('users')->onDelete('cascade')->after('course_id');
            $table->enum('status', ['active', 'inactive', 'draft'])->default('active')->after('teacher_id');
            
            // Additional useful fields
            $table->integer('order')->default(0)->after('status'); // for lesson ordering within course
            $table->boolean('is_free')->default(false)->after('order'); // for free preview lessons
            $table->timestamp('published_at')->nullable()->after('is_free'); // when lesson was published
        });
    }

    public function down(): void
    {
        Schema::table('lessons', function (Blueprint $table) {
            $table->dropColumn([
                'video_name',
                'video_size', 
                'video_duration',
                'teacher_id',
                'status',
                'order',
                'is_free',
                'published_at'
            ]);
        });
    }
};