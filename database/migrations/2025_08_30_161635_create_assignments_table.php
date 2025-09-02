<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('assignments', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('files')->nullable(); // يمكن تخزين أسماء الملفات كـ JSON
            $table->dateTime('deadline')->nullable();
            $table->boolean('is_open')->default(false); // لو true يبقى مفيش deadline
            $table->integer('total_mark')->default(0);
            $table->unsignedBigInteger('group_id')->nullable();
            $table->unsignedBigInteger('lesson_id')->nullable();
            $table->timestamps();

            $table->foreign('group_id')->references('id')->on('groups')->nullOnDelete();
            $table->foreign('lesson_id')->references('id')->on('lessons')->nullOnDelete();
        });
    }

    public function down(): void {
        Schema::dropIfExists('assignments');
    }
};
