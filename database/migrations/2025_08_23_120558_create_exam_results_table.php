<?php

// database/migrations/2025_08_29_000005_create_exam_results_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('exam_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exam_id')->constrained()->cascadeOnDelete();
            $table->foreignId('student_id')->constrained('users')->cascadeOnDelete();
            $table->integer('student_degree')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('exam_results');
    }
};
