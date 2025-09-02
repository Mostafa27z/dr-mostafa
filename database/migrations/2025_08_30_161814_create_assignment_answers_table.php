<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('assignment_answers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('assignment_id');
            $table->string('answer_file')->nullable();   // ملف الحل
            $table->longText('answer_text')->nullable(); // نص الحل
            $table->longText('teacher_comment')->nullable();
            $table->integer('teacher_degree')->nullable();
            $table->string('teacher_file')->nullable(); // ملف إضافي من المعلم (تصحيح مثلاً)
            $table->timestamps();

            $table->foreign('student_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('assignment_id')->references('id')->on('assignments')->cascadeOnDelete();
        });
    }

    public function down(): void {
        Schema::dropIfExists('assignment_answers');
    }
};
