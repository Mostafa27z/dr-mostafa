<?php
// database/migrations/2025_08_29_000002_create_exam_questions_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('exam_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exam_id')->constrained()->cascadeOnDelete();
            $table->string('title'); 
            $table->integer('degree')->default(1); // 🔑 لازم نعرف السؤال بدرجة كام
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('exam_questions');
    }
};
