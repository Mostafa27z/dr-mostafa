<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('exam_questions', function (Blueprint $table) {
        $table->id();
        $table->foreignId('exam_id')->constrained()->onDelete('cascade');
        $table->text('question_text');
        $table->enum('type', ['mcq','essay']);
        $table->integer('marks');
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exam_questions');
    }
};
