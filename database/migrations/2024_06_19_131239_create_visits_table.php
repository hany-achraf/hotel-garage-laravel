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
        Schema::create('visits', function (Blueprint $table) {
            $table->id();
            $table->string('qr_code')->unique();
            $table->string('plate_no');
            $table->string('email')->nullable();
            $table->string('phone_no')->nullable();
            $table->foreignIdFor(\App\Models\SecurityGuard::class, 'entry_guard_id')->constrained('security_guards')->restrictOnDelete()->cascadeOnUpdate();
            $table->foreignIdFor(\App\Models\Gate::class, 'entry_gate_id')->constrained('gates')->restrictOnDelete()->cascadeOnUpdate();
            $table->timestamp('entry_time');
            $table->foreignIdFor(\App\Models\SecurityGuard::class, 'exit_guard_id')->nullable()->constrained('security_guards')->restrictOnDelete()->cascadeOnUpdate();
            $table->foreignIdFor(\App\Models\Gate::class, 'exit_gate_id')->nullable()->constrained('gates')->restrictOnDelete()->cascadeOnUpdate();
            $table->timestamp('exit_time')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visits');
    }
};
