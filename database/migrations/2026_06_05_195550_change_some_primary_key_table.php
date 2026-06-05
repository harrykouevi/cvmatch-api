<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    /**
     * Run the migrations.
     */
     public function up(): void
    {
        // =========================
        // 1. ADD UUID COLUMNS
        // =========================

        Schema::table('credit_plans', function (Blueprint $table) {
            $table->uuid('uuid')->nullable()->unique()->after('id');
        });



        // =========================
        // 2. BACKFILL EXISTING DATA
        // =========================

        DB::table('credit_plans')->orderBy('id')->chunk(200, function ($rows) {
            foreach ($rows as $row) {
                DB::table('credit_plans')
                    ->where('id', $row->id)
                    ->update(['uuid' => (string) Str::uuid()]);
            }
        });



        // =========================
        // 3. MAKE NOT NULL (SAFE STEP)
        // =========================

        Schema::table('credit_plans', function (Blueprint $table) {
            $table->uuid('uuid')->nullable(false)->change();
        });


    }

    public function down(): void
    {
        Schema::table('credit_plans', function (Blueprint $table) {
            $table->dropColumn('uuid');
        });


    }
};
