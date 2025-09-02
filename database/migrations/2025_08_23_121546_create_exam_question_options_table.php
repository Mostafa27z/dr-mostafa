<?php

// database/migrations/2025_08_29_000003_create_exam_question_options_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('exam_question_options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exam_question_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->boolean('is_correct')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('exam_question_options');
    }
};
