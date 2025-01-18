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
        Schema::create('lines_modifiers', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('line_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('modifier_id');

            $table->foreign('modifier_id')->references('id')->on('modifiers')->cascadeOnUpdate()->cascadeOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lines_modifiers');
    }
};
