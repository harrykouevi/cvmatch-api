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
        Schema::create('credits', function (Blueprint $table) {
            $table->id();

            $table->foreignId('tenant_id')
                ->nullable()
                ->constrained('tenants')
                ->nullOnDelete()
                ->cascadeOnUpdate();

            // L’utilisateur qui achète
            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete()
                ->cascadeOnUpdate();

            $table->integer('balance')->default(0);
            $table->integer('used')->default(0);
            $table->integer('purchased_total')->default(0);



            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('credits');
    }
};
