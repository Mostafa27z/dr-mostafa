<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('exam_attempts', function (Blueprint $table) {
            $table->timestamp('ended_at')->nullable()->after('submitted_at');
            $table->boolean('submitted')->default(false)->after('ended_at');
            $table->boolean('auto_submitted')->default(false)->after('submitted');
        });
    }

    public function down(): void
    {
        Schema::table('exam_attempts', function (Blueprint $table) {
            $table->dropColumn(['ended_at', 'submitted', 'auto_submitted']);
        });
    }
};
