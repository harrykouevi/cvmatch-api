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
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();

            // L’utilisateur qui achète
             $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete()
                ->cascadeOnUpdate();

             $table->foreignId('tenant_id')
                ->nullable()
                ->constrained('tenants')
                ->nullOnDelete()
                ->cascadeOnUpdate();

            // Lien vers le paiement réel (Stripe)
            $table->foreignId('payment_id')
                ->nullable()
                ->constrained('payments')
                ->nullOnDelete()
                ->cascadeOnUpdate();

            // $table->morphs('product');
            $table->string('product_type', 125);
            $table->unsignedBigInteger('product_id');
            $table->json('product_snapshot_json')->nullable();

            // pending | paid | refunded
            $table->string('status', 125)->default('pending');


            // Montant côté métier (optionnel mais utile pour historique)
            $table->integer('amount');
            $table->string('currency', 10)->default('usd');
            $table->timestamp('purchased_at');

            $table->timestamps();

            // Index utiles
            $table->index(['user_id', 'status']);
            $table->index('payment_id');
            $table->index(['product_type', 'product_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchases');
    }
};
