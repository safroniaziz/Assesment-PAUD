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
        Schema::table('recommendations', function (Blueprint $table) {
            // Drop aspect_id foreign key as recommendations are now overall, not per-aspect
            $table->dropForeign(['aspect_id']);
            $table->dropColumn('aspect_id');
            
            // Change category enum to maturity categories
            $table->dropColumn('category');
        });
        
        Schema::table('recommendations', function (Blueprint $table) {
            $table->enum('maturity_category', ['matang', 'cukup_matang', 'kurang_matang', 'tidak_matang'])->after('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('recommendations', function (Blueprint $table) {
            $table->dropColumn('maturity_category');
        });
        
        Schema::table('recommendations', function (Blueprint $table) {
            $table->foreignId('aspect_id')->after('id')->constrained('assessment_aspects')->onDelete('cascade');
            $table->enum('category', ['low', 'medium', 'high'])->after('aspect_id');
        });
    }
};
