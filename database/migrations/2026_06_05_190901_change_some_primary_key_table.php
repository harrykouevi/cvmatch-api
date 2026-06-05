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
     public function up(): void
    {
        // =========================
        // 1. ADD UUID COLUMNS
        // =========================

        Schema::table('resumes', function (Blueprint $table) {
            $table->uuid('uuid')->nullable()->unique()->after('id');
        });

        Schema::table('analyses', function (Blueprint $table) {
            $table->uuid('uuid')->nullable()->unique()->after('id');
        });

        Schema::table('payments', function (Blueprint $table) {
            $table->uuid('uuid')->nullable()->unique()->after('id');
        });

        Schema::table('purchases', function (Blueprint $table) {
            $table->uuid('uuid')->nullable()->unique()->after('id');
        });

        // =========================
        // 2. BACKFILL EXISTING DATA
        // =========================

        DB::table('resumes')->orderBy('id')->chunk(200, function ($rows) {
            foreach ($rows as $row) {
                DB::table('resumes')
                    ->where('id', $row->id)
                    ->update(['uuid' => (string) Str::uuid()]);
            }
        });

        DB::table('analyses')->orderBy('id')->chunk(200, function ($rows) {
            foreach ($rows as $row) {
                DB::table('analyses')
                    ->where('id', $row->id)
                    ->update(['uuid' => (string) Str::uuid()]);
            }
        });

        DB::table('payments')->orderBy('id')->chunk(200, function ($rows) {
            foreach ($rows as $row) {
                DB::table('payments')
                    ->where('id', $row->id)
                    ->update(['uuid' => (string) Str::uuid()]);
            }
        });

        DB::table('purchases')->orderBy('id')->chunk(200, function ($rows) {
            foreach ($rows as $row) {
                DB::table('purchases')
                    ->where('id', $row->id)
                    ->update(['uuid' => (string) Str::uuid()]);
            }
        });

        // =========================
        // 3. MAKE NOT NULL (SAFE STEP)
        // =========================

        Schema::table('resumes', function (Blueprint $table) {
            $table->uuid('uuid')->nullable(false)->change();
        });

        Schema::table('analyses', function (Blueprint $table) {
            $table->uuid('uuid')->nullable(false)->change();
        });

        Schema::table('payments', function (Blueprint $table) {
            $table->uuid('uuid')->nullable(false)->change();
        });

        Schema::table('purchases', function (Blueprint $table) {
            $table->uuid('uuid')->nullable(false)->change();
        });
    }

    public function down(): void
    {
        Schema::table('resumes', function (Blueprint $table) {
            $table->dropColumn('uuid');
        });

        Schema::table('analyses', function (Blueprint $table) {
            $table->dropColumn('uuid');
        });

        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn('uuid');
        });

        Schema::table('purchases', function (Blueprint $table) {
            $table->dropColumn('uuid');
        });
    }
};
