<?php

namespace Tests\Feature\Http\Controllers\Api;

use App\Models\Resume;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use Tests\TestCase;

class AnalyseControllerTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * A basic feature test example.
     */
    public function  test_free(): void
    {

        try{
            // Créer un utilisateur et se connecter
            $user = $this->createUser(2);

            // Self-contained: create the resume this test needs.
            $resume = Resume::create([
                'user_id'        => $user->id,
                'extracted_text' => 'Resume text ' . Str::random(40),
            ]);

            $response = $this->actingAs($user, 'sanctum')->postJson(route('analyses.store'), [
                'resume_id' => $resume->id ,
                'job_description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer vitae eros nec justo vehicula hendrerit. Suspendisse potenti. Curabitur euismod, nisl at fermentum tincidunt, nunc magna ultrices sapien, sed cursus nulla orci non nisl. Donec a massa vel ligula volutpat aliquam',
            ]);

            $response->assertStatus(200);

        } catch (\Exception $e) {
            Log::error('FAIL:'. $e->getMessage() , [
                 'trace' => $e->getTraceAsString()
            ]);
            throw $e ;
        }
    }

    private function createUser(int $role = 2){
            // Créer un utilisateur et se connecter
        $user = User::create([

            'name' => Str::random(10),
            'email' => Str::random(10).'@exampdle.com',
            // 'phone_number' => '+00228'.Str::random(8),
            // 'phone_verified_at' => now(),
            // 'email_verified_at' => now(),
            'password' => Hash::make('password125'),
            // 'api_token' => Str::random(60),
            // 'device_token' => '',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        // $user->assignRole(2);

        return $user ;
    }


    public function  test_show(): void
    {

        try{
            // Créer un utilisateur et se connecter
            $user = $this->createUser(2);

            // Self-contained: the user views their own analysis.
            $analyse = $this->makeAnalyse($user);

            $response = $this->actingAs($user, 'sanctum')->getJson(route('analyses.show', $analyse->id));

            $response->assertStatus(200);

        } catch (\Exception $e) {
            Log::error('FAIL:'. $e->getMessage() , [
                 'trace' => $e->getTraceAsString()
            ]);
            throw $e ;
        }
    }


    public function  test_download(): void
    {

        try{
            // Créer un utilisateur et se connecter
            $user = $this->createUser(2);

            $response = $this->actingAs($user, 'api')->getJson(route('analyses.download.resume',1));

            Log::info('response:', [$response->getContent()]);
            $response->assertStatus(200);
            $response->assertHeader('content-type', 'application/pdf');

        } catch (\Exception $e) {
            Log::error('FAIL:'. $e->getMessage() , [
                 'trace' => $e->getTraceAsString()
            ]);
            throw $e ;
        }
    }

    // ---------------------------------------------------------------------
    // Security tests: ownership (IDOR) + unlock idempotency.
    // These are self-contained (create their own data) and run inside a
    // transaction so they do not depend on or mutate seeded rows.
    // ---------------------------------------------------------------------

    /** Create a resume owned by the given user. */
    private function makeResume(\App\Models\User $user): \App\Models\Resume
    {
        return \App\Models\Resume::create([
            'user_id'        => $user->id,
            'extracted_text' => 'Original resume text ' . Str::random(20),
        ]);
    }

    /** Create an analysis owned by the given user (with a resume). */
    private function makeAnalyse(\App\Models\User $user, array $overrides = []): \App\Models\Analyse
    {
        $resume = $this->makeResume($user);

        return \App\Models\Analyse::create(array_merge([
            'user_id'               => $user->id,
            'resume_id'             => $resume->id,
            'status'                => 'completed',
            'is_full_unlocked'      => false,
            'score'                 => 62,
            'optimized_resume_text' => 'Optimized resume text ' . Str::random(40),
        ], $overrides));
    }

    /** Give the user a credit wallet with the given balance. */
    private function giveCredits(\App\Models\User $user, int $balance): \App\Models\Credit
    {
        return \App\Models\Credit::create([
            'user_id' => $user->id,
            'balance' => $balance,
            'used'    => 0,
        ]);
    }

    public function test_user_cannot_view_another_users_analysis(): void
    {
        $userA = $this->createUser();
        $userB = $this->createUser();

        $analyseB = $this->makeAnalyse($userB);

        $response = $this->actingAs($userA, 'sanctum')
            ->getJson(route('analyses.show', $analyseB->id));

        // Ownership criteria scopes the lookup to the caller, so User B's
        // analysis is "not found" for User A. Must NOT return B's data.
        $this->assertNotEquals(200, $response->getStatusCode());
        $response->assertDontSee($analyseB->resume->extracted_text);
    }

    public function test_user_cannot_unlock_another_users_analysis_and_no_credit_consumed(): void
    {
        $userA = $this->createUser();
        $userB = $this->createUser();

        $analyseB = $this->makeAnalyse($userB);
        $walletA  = $this->giveCredits($userA, 5);

        $response = $this->actingAs($userA, 'sanctum')
            ->postJson(route('analyses.unlock', $analyseB->id));

        $this->assertNotEquals(200, $response->getStatusCode());

        // User A's balance must be untouched; User B's analysis still locked.
        $this->assertEquals(5, $walletA->fresh()->balance);
        $this->assertFalse((bool) $analyseB->fresh()->is_full_unlocked);
    }

    public function test_user_cannot_download_another_users_resume(): void
    {
        $userA = $this->createUser();
        $userB = $this->createUser();

        $analyseB = $this->makeAnalyse($userB);

        $response = $this->actingAs($userA, 'sanctum')
            ->get(route('analyses.download.resume', $analyseB->id));

        // Must not return another user's PDF.
        $this->assertNotEquals(200, $response->getStatusCode());
    }

    public function test_unlock_is_idempotent_and_charges_only_once(): void
    {
        $user    = $this->createUser();
        $analyse = $this->makeAnalyse($user);
        $wallet  = $this->giveCredits($user, 2);

        // First unlock: charges exactly 1 credit, marks unlocked.
        $first = $this->actingAs($user, 'sanctum')
            ->postJson(route('analyses.unlock', $analyse->id));
        $first->assertStatus(200);

        $this->assertEquals(1, $wallet->fresh()->balance);
        $this->assertTrue((bool) $analyse->fresh()->is_full_unlocked);

        // Second unlock on the same analysis: must NOT charge again.
        $second = $this->actingAs($user, 'sanctum')
            ->postJson(route('analyses.unlock', $analyse->id));
        $second->assertStatus(200);

        $this->assertEquals(1, $wallet->fresh()->balance);
        $this->assertTrue((bool) $analyse->fresh()->is_full_unlocked);
    }

    // Guest cross-access (wrong X-Guest-Token cannot reach another guest's
    // analysis) is PENDING: it needs guest-token header setup and a guest
    // user factory; deferred to avoid a brittle test. The authenticated-user
    // IDOR cases above already exercise the same AnalyseOfUserCriteria scoping.
    public function test_guest_cross_access_is_pending(): void
    {
        $this->markTestSkipped('Guest-token cross-access test pending guest flow test helpers.');
    }
}
