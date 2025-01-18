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
        Schema::create('invoices', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('title')->nullable();
            $table->string('info')->nullable();
            $table->string('reference')->nullable();
            $table->dateTime('recieved_at')->nullable();
            $table->dateTime('due_at')->nullable();
            $table->foreignId('payable_to')->constrained('entities')->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('payable_by')->constrained('entities')->cascadeOnUpdate()->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
