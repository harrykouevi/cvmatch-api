<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Statut guest
            $table->boolean('is_guest')->default(true)->after('password');

            // Token unique pour cookie
            $table->uuid('guest_token')->nullable()->unique()->after('is_guest');

            // Email vérifié (si pas déjà présent)
            if (!Schema::hasColumn('users', 'email_verified_at')) {
                $table->timestamp('email_verified_at')->nullable()->after('email');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'is_guest',
                'guest_token',
                'email_verified_at',
            ]);
        });
    }
};
