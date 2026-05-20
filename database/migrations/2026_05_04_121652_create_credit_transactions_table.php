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
        Schema::create('credit_transactions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('tenant_id')
                ->nullable()
                ->constrained('tenants')
                ->nullOnDelete()
                ->cascadeOnUpdate();

            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete()
                ->cascadeOnUpdate();

            $table->foreignId('payment_id')
                ->nullable()
                ->constrained('payments')
                ->nullOnDelete()
                ->cascadeOnUpdate();

            $table->enum('type', ['purchase', 'usage', 'refund', 'bonus']);

            $table->integer('credits'); // ex: +10, -1

            $table->integer('balance_after'); // solde après transaction

            $table->json('snapshot_json')->nullable();

            $table->string('description')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('credit_transactions');
    }
};
