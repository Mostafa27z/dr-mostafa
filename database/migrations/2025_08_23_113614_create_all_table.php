<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Teachers
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password'); // for login
            $table->timestamps();
        });

        // Students
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password'); // for login
            $table->timestamps();
        });

        // Courses
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->foreignId('teacher_id')->constrained('teachers')->onDelete('cascade');
            $table->timestamps();
        });

        // Lessons (linked to Courses)
        Schema::create('lessons', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('video_path')->nullable(); // one video per lesson
            $table->foreignId('course_id')->constrained('courses')->onDelete('cascade');
            $table->timestamps();
        });

        // Lesson PDFs
        Schema::create('lesson_pdfs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lesson_id')->constrained('lessons')->onDelete('cascade');
            $table->string('title');     // pdf title
            $table->string('file_path'); // pdf path
            $table->timestamps();
        });

        // Groups (for sessions, not related to courses)
        Schema::create('groups', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        // Sessions (linked to groups)
        Schema::create('group-sessions', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->dateTime('scheduled_at');
            $table->string('meeting_link')->nullable();
            $table->foreignId('group_id')->constrained('groups')->onDelete('cascade');
            $table->timestamps();
        });

        // Session PDFs
        Schema::create('session_pdfs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('session_id')->constrained('group-sessions')->onDelete('cascade');
            $table->string('title');     // pdf title
            $table->string('file_path'); // pdf path
            $table->timestamps();
        });

        // Pivot: student_course
        Schema::create('student_course', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->foreignId('course_id')->constrained('courses')->onDelete('cascade');
            $table->timestamps();
        });

        // Pivot: group_student
        Schema::create('group_student', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->foreignId('group_id')->constrained('groups')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('group_student');
        Schema::dropIfExists('student_course');
        Schema::dropIfExists('session_pdfs');
        Schema::dropIfExists('group-sessions');
        Schema::dropIfExists('groups');
        Schema::dropIfExists('lesson_pdfs');
        Schema::dropIfExists('lessons');
        Schema::dropIfExists('courses');
        Schema::dropIfExists('students');
        Schema::dropIfExists('teachers');
    }
};
