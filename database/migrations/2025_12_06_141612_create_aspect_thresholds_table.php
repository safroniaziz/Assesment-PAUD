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
        Schema::create('aspect_thresholds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('aspect_id')->constrained('assessment_aspects')->onDelete('cascade');
            $table->integer('baik_min');
            $table->integer('baik_max');
            $table->integer('cukup_min');
            $table->integer('cukup_max');
            $table->integer('kurang_max');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aspect_thresholds');
    }
};
