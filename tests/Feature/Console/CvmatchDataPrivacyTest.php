<?php

namespace Tests\Feature\Console;

use App\Models\Analyse;
use App\Models\CreditPlan;
use App\Models\Resume;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Tests\TestCase;

/**
 * Covers privacy commands:
 *   cvmatch:purge-user-data {email}
 *   cvmatch:cleanup-old-data
 *
 * Self-contained (creates its own data), no real CV content.
 */
class CvmatchDataPrivacyTest extends TestCase
{
    use DatabaseTransactions;

    private function makeUser(): User
    {
        return User::create([
            'name'     => Str::random(8),
            'email'    => Str::random(10) . '@example.com',
            'password' => Hash::make('password125'),
        ]);
    }

    private function makeResumeWithAnalyse(User $user, ?string $createdAt = null): array
    {
        $resume = Resume::create([
            'user_id'        => $user->id,
            'extracted_text' => 'fictional resume text ' . Str::random(20),
        ]);
        $analyse = Analyse::create([
            'user_id'               => $user->id,
            'resume_id'             => $resume->id,
            'status'                => 'completed',
            'optimized_resume_text' => 'fictional optimized ' . Str::random(20),
            'cover_letter'          => 'fictional cover ' . Str::random(20),
        ]);
        if ($createdAt) {
            $resume->forceFill(['created_at' => $createdAt])->save();
            $analyse->forceFill(['created_at' => $createdAt])->save();
        }
        return [$resume, $analyse];
    }

    public function test_purge_user_data_removes_sensitive_data_for_user(): void
    {
        $user = $this->makeUser();
        [$resume, $analyse] = $this->makeResumeWithAnalyse($user);

        $this->artisan('cvmatch:purge-user-data', ['email' => $user->email])
            ->assertExitCode(0);

        $this->assertDatabaseMissing('analyses', ['id' => $analyse->id]);
        $this->assertDatabaseMissing('resumes', ['id' => $resume->id]);
    }

    public function test_purge_user_data_does_not_affect_other_user(): void
    {
        $userA = $this->makeUser();
        $userB = $this->makeUser();
        [$resumeB, $analyseB] = $this->makeResumeWithAnalyse($userB);

        $this->artisan('cvmatch:purge-user-data', ['email' => $userA->email])
            ->assertExitCode(0);

        $this->assertDatabaseHas('analyses', ['id' => $analyseB->id]);
        $this->assertDatabaseHas('resumes', ['id' => $resumeB->id]);
    }

    public function test_purge_user_data_unknown_email_exits_cleanly(): void
    {
        $this->artisan('cvmatch:purge-user-data', ['email' => 'nobody-' . Str::random(6) . '@example.com'])
            ->assertExitCode(0);
    }

    public function test_cleanup_old_data_removes_old_records(): void
    {
        $user = $this->makeUser();
        [$resume, $analyse] = $this->makeResumeWithAnalyse($user, now()->subDays(200)->toDateTimeString());

        $this->artisan('cvmatch:cleanup-old-data', ['--days' => 90])
            ->assertExitCode(0);

        $this->assertDatabaseMissing('analyses', ['id' => $analyse->id]);
        $this->assertDatabaseMissing('resumes', ['id' => $resume->id]);
    }

    public function test_cleanup_old_data_keeps_fresh_records(): void
    {
        $user = $this->makeUser();
        [$resume, $analyse] = $this->makeResumeWithAnalyse($user, now()->subDays(5)->toDateTimeString());

        $this->artisan('cvmatch:cleanup-old-data', ['--days' => 90])
            ->assertExitCode(0);

        $this->assertDatabaseHas('analyses', ['id' => $analyse->id]);
        $this->assertDatabaseHas('resumes', ['id' => $resume->id]);
    }

    public function test_cleanup_does_not_delete_credit_plans(): void
    {
        // Dummy test plan (required non-null columns set). Not production pricing.
        $plan = CreditPlan::create([
            'name'                => 'Test Plan ' . Str::random(5),
            'price'               => 500,
            'credits'             => 1,
            'provider'            => 'test',
            'provider_product_id' => 'test_' . Str::random(8),
            'is_active'           => true,
        ]);

        $this->artisan('cvmatch:cleanup-old-data', ['--days' => 1])
            ->assertExitCode(0);

        $this->assertDatabaseHas('credit_plans', ['id' => $plan->id]);
    }
}
