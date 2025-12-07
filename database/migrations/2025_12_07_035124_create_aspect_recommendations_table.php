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
        Schema::create('aspect_recommendations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('aspect_id')->constrained('assessment_aspects')->onDelete('cascade');
            $table->enum('maturity_level', ['matang', 'cukup_matang', 'kurang_matang', 'tidak_matang']);
            
            // Recommendation text fields
            $table->text('analysis_notes')->nullable()->comment('Catatan Analisa');
            $table->text('recommendation_for_child')->nullable()->comment('Rekomendasi untuk Anak');
            $table->text('recommendation_for_teacher')->nullable()->comment('Rekomendasi untuk Guru');
            $table->text('recommendation_for_parent')->nullable()->comment('Rekomendasi untuk Orangtua');
            
            $table->timestamps();
            
            // Unique constraint: only one recommendation per aspect per maturity level
            $table->unique(['aspect_id', 'maturity_level'], 'unique_aspect_maturity');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aspect_recommendations');
    }
};
