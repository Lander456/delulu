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
        Schema::create('AOI_target_demographic', function (Blueprint $table) {
            $table->foreignId('target_demographic_id')->constrained('target_demographics')->cascadeOnDelete();
            $table->foreignId('areas_of_interest_id')->constrained('area_of_interests')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('AOI_target_demographic');
    }
};
