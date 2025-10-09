<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('exam_answers', function (Blueprint $table) {
            $table->foreignId('exam_attempt_id')->nullable()->after('student_id')->constrained('exam_attempts')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('exam_answers', function (Blueprint $table) {
            $table->dropForeign(['exam_attempt_id']);
            $table->dropColumn('exam_attempt_id');
        });
    }
};
