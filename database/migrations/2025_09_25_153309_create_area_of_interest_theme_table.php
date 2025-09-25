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
        Schema::create('area_of_interest_theme', function (Blueprint $table) {
            $table->foreignId('theme_id')->constrained('themes')->cascadeOnDelete();
            $table->foreignId('area_of_interest_id')->constrained('area_of_interests')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('area_of_interest_theme');
    }
};
