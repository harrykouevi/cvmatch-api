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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('tenant_id')
                ->nullable()
                ->constrained('tenants')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->foreignId('analysis_id')
                ->nullable()
                ->constrained('analyses')
                ->nullOnDelete()
                ->cascadeOnUpdate();

            $table->string('user_email')->nullable();

            // snapshot du plan (important pour historique)
            $table->json('plan')->nullable();
            $table->integer('amount');

            $table->string('currency')->default('usd');

            // $table->string('stripe_session_id', 191)->unique();
            // $table->string('stripe_payment_intent_id')->nullable();

            // $table->string('status')->default('pending');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
