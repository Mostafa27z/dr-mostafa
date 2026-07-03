<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // First, update any existing null values to sensible defaults
        DB::table('exams')
            ->whereNull('start_time')
            ->orWhereNull('end_time')
            ->update([
                'start_time' => DB::raw('COALESCE(start_time, NOW())'),
                'end_time' => DB::raw('COALESCE(end_time, DATE_ADD(NOW(), INTERVAL 1 HOUR))'),
            ]);

        Schema::table('exams', function (Blueprint $table) {
            $table->timestamp('start_time')->useCurrent()->nullable(false)->change();
            $table->timestamp('end_time')->useCurrent()->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('exams', function (Blueprint $table) {
            $table->timestamp('start_time')->nullable()->change();
            $table->timestamp('end_time')->nullable()->change();
        });
    }
};
