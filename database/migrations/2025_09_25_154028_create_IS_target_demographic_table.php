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
        Schema::create('IS_target_demographic', function (Blueprint $table) {
            $table->foreignId('information_source_id')->constrained('information_sources')->cascadeOnDelete();
            $table->foreignId('target_demographic_id')->constrained('target_demographics')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('IS_target_demographic');
    }
};
