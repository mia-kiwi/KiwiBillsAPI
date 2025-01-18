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
            $table->dateTime('recieved_at')->nullable()->default(now());
            $table->dateTime('due_at')->nullable();
            $table->string('issued_at')->nullable();
            $table->string('issued_by')->nullable();
            $table->string('payable_to')->nullable();
            $table->string('payable_by')->nullable();

            $table->foreign('issued_by')->references('id')->on('entities')->cascadeOnUpdate()->nullOnDelete();
            $table->foreign('payable_to')->references('id')->on('entities')->cascadeOnUpdate()->nullOnDelete();
            $table->foreign('payable_by')->references('id')->on('entities')->cascadeOnUpdate()->nullOnDelete();

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
