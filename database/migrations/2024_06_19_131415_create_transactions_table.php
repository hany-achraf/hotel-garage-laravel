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
            $table->id();
            $table->foreignIdFor(\App\Models\Visit::class)->nullable()->constrained()->restrictOnDelete()->cascadeOnUpdate();
            $table->unsignedInteger('amount');
            $table->enum('transaction_type', ['payment', 'cash_collection']);
            $table->enum('payment_method', ['online', 'cash'])->nullable();
            // $table->timestamp('transaction_time');
            $table->foreignIdFor(\App\Models\SecurityGuard::class)->nullable()->constrained()->restrictOnDelete()->cascadeOnUpdate();
            $table->foreignIdFor(\App\Models\Admin::class)->nullable()->constrained()->restrictOnDelete()->cascadeOnUpdate();
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
