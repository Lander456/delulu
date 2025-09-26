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
        Schema::create('information_source_theme', function (Blueprint $table) {
            $table->foreignId('information_source_id')
                ->constrained('information_sources')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->foreignId('theme_id')
                ->constrained('themes')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('information_source_theme');
    }
};
