<?php

// database/migrations/2025_08_29_000001_create_exams_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('exams', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->foreignId('lesson_id')->constrained()->onDelete('cascade');
            $table->text('description')->nullable();
            $table->timestamp('start_time')->nullable();
            $table->timestamp('end_time')->nullable();
            $table->integer('duration')->nullable(); // minutes
            $table->boolean('is_open')->default(false); // no duration if true
            $table->boolean('is_limited')->default(true); // false => no start/end
            $table->integer('total_degree');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('exams');
    }
};

