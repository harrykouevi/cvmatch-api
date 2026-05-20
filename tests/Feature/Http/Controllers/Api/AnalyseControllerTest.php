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
    // use DatabaseTransactions;

    /**
     * A basic feature test example.
     */
    public function  test_free(): void
    {

        try{
            // Créer un utilisateur et se connecter
            $user = $this->createUser(2);
            // $resume = Resume::create([
            //     'user_id' => $user->id ,
            //     'extracted_text' => Str::random(60)

            // ]);

            $resume = Resume::where('id',1 )->first()  ;



            $response = $this->actingAs($user, 'api')->postJson(route('analyses.store'), [
                'resume_id' => $resume->id ,
                'job_description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer vitae eros nec justo vehicula hendrerit. Suspendisse potenti. Curabitur euismod, nisl at fermentum tincidunt, nunc magna ultrices sapien, sed cursus nulla orci non nisl. Donec a massa vel ligula volutpat aliquam',
            ]);

            // dd($response->json());
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

            $response = $this->actingAs($user, 'api')->getJson(route('analyses.show',5));

            dd($response->json());
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
}
