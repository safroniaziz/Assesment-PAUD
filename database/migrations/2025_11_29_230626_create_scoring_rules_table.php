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
        Schema::create('scoring_rules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('aspect_id')->constrained('assessment_aspects')->onDelete('cascade');
            $table->integer('min_age_months'); // Minimum age in months (e.g., 48 = 4 years)
            $table->integer('max_age_months'); // Maximum age in months (e.g., 59 = 4 years 11 months)
            $table->decimal('low_threshold', 5, 2)->default(50.00); // Below this = Low
            $table->decimal('medium_threshold', 5, 2)->default(80.00); // Below this = Medium, above = High
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scoring_rules');
    }
};
