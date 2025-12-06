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
        Schema::table('assessment_sessions', function (Blueprint $table) {
            $table->enum('maturity_category', ['matang', 'cukup_matang', 'kurang_matang', 'tidak_matang'])->nullable()->after('completed_at');
            $table->foreignId('recommendation_id')->nullable()->after('maturity_category')->constrained('recommendations')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('assessment_sessions', function (Blueprint $table) {
            $table->dropForeign(['recommendation_id']);
            $table->dropColumn(['maturity_category', 'recommendation_id']);
        });
    }
};
