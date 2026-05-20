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


            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete()
                ->cascadeOnUpdate();

            $table->foreignId('resume_id')
                ->nullable()
                ->constrained('resumes')
                ->nullOnDelete()
                ->cascadeOnUpdate();

            $table->longText('job_description');
            $table->longText('job_fit_summary')->nullable();

            $table->string('market')->default('US');
            $table->string('status');

            $table->integer('score')->default(0);

            $table->string('match_level')->nullable();
            $table->json('score_breakdown_json')->nullable();
            $table->json('missing_keywords_json')->nullable();
            $table->json('missing_hard_skills_json')->nullable();
            $table->json('weak_sections_json')->nullable();
            $table->json('strong_points_json')->nullable();
            $table->json('detected_problems_json')->nullable();
            $table->json('recruiter_risk_flags_json')->nullable();

            $table->json('recommendations_json')->nullable();
            $table->json('warnings_json')->nullable();
            $table->json('optimized_resume_analysis_json')->nullable();



            $table->json('optimized_resume')->nullable();
            $table->longText('optimized_resume_text')->nullable();
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
