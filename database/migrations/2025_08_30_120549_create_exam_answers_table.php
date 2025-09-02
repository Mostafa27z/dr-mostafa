<?php

// database/migrations/2025_08_29_000004_create_exam_answers_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('exam_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('exam_question_id')->constrained()->cascadeOnDelete();
            $table->foreignId('exam_question_option_id')->nullable()->constrained()->nullOnDelete(); // student choice
            $table->foreignId('correct_option_id')->nullable()->constrained('exam_question_options')->nullOnDelete();
            $table->integer('degree')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('exam_answers');
    }
};
