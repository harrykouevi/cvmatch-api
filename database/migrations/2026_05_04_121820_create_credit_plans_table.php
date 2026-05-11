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
        Schema::create('credit_plans', function (Blueprint $table) {
            $table->id();

            $table->string('name'); // basic, pro, gold

            $table->integer('price'); // en centimes (ex: 1000 = 10$)

            $table->string('currency', 10)->default('usd');

            $table->integer('credits')->default(0); // nombre de crédits

            $table->string('provider');
            $table->string('provider_product_id');
            $table->json('provider_product_snapshot_json')->nullable();

            $table->boolean('is_active')->default(true);

            $table->timestamp('synced_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('credit_plans');
    }
};
