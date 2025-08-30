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
    Schema::create('exam_results', function (Blueprint $table) {
        $table->id();
        $table->foreignId('exam_id')->constrained()->onDelete('cascade');
        $table->foreignId('student_id')->constrained()->onDelete('cascade');
        $table->integer('total_marks');
        $table->integer('obtained_marks');
        $table->enum('status',['passed','failed']);
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exam_results');
    }
};
