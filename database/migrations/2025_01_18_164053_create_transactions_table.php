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
        Schema::create('transactions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->text('description')->nullable();
            $table->decimal('amount', 10, 2);
            $table->string('currency_id', 4);
            $table->dateTime('payment_date')->default(now());

            $table->foreignUuid('invoice_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('currency_id')->references('id')->on('currencies')->cascadeOnUpdate()->nullOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
