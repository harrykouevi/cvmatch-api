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
                ->nullOnDelete()
                ->cascadeOnUpdate();

            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();



            // stripe | gumroad | paypal
            $table->string('provider', 50);
            $table->string('provider_payment_id', 120);

            $table->integer('amount');

            $table->string('currency')->default('usd');

            // pending | paid | failed | refunded
            $table->string('status', 50)->default('pending');
            $table->json('meta_json')->nullable();
            $table->timestamp('paid_at')->nullable();

            $table->timestamps();
            $table->index(['provider', 'provider_payment_id']);
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
