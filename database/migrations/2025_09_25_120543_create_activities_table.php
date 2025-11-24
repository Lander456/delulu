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
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('step_id')
                ->constrained('steps')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->string('name');
            $table->text('description')
                ->nullable();
            $table->float('success')->default(0);
            $table->boolean('completed')
                ->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activities');
    }
};
