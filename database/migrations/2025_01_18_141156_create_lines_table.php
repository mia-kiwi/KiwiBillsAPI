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
        Schema::create('lines', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->integer('index', false, true);
            $table->text('description')->nullable();
            $table->integer('quantity', false, true)->default(1);
            $table->decimal('vat', 5, 2)->default(0);
            $table->foreignUuid('item_id')->constrained('items', 'id')->cascadeOnUpdate()->nullOnDelete();
            $table->foreignUuid('invoice_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lines');
    }
};
