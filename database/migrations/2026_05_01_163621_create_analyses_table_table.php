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
        Schema::create('analyses', function (Blueprint $table) {
            $table->id();

            $table->foreignId('tenant_id')
                ->nullable()
                ->constrained('tenants')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->foreignId('resume_id')
                ->constrained('resumes')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->longText('job_description');

            $table->string('market')->default('US');
            $table->string('status');

            $table->integer('score')->default(0);

            $table->json('score_breakdown_json')->nullable();
            $table->json('critical_problems_json')->nullable();
            $table->json('missing_keywords_json')->nullable();

            $table->json('ats_issues_json')->nullable();

            $table->longText('optimized_resume')->nullable();
            $table->longText('cover_letter')->nullable();

            // $table->boolean('is_paid')->default(false);
            $table->boolean('is_full_unlocked')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('analyses');
    }
};
