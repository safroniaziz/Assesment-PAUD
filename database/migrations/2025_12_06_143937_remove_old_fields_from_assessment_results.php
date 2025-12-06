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
        Schema::table('assessment_results', function (Blueprint $table) {
            // Drop old columns that are no longer used
            if (Schema::hasColumn('assessment_results', 'percentage')) {
                $table->dropColumn('percentage');
            }
            if (Schema::hasColumn('assessment_results', 'category')) {
                $table->dropColumn('category');
            }
            if (Schema::hasColumn('assessment_results', 'recommendation_id')) {
                $table->dropForeign(['recommendation_id']);
                $table->dropColumn('recommendation_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('assessment_results', function (Blueprint $table) {
            $table->decimal('percentage', 5, 2)->nullable();
            $table->enum('category', ['low', 'medium', 'high'])->nullable();
            $table->foreignId('recommendation_id')->nullable()->constrained('recommendations')->onDelete('set null');
        });
    }
};
