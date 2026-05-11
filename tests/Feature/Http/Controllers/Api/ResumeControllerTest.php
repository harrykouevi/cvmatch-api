<?php

namespace Tests\Feature\Http\Controllers\Api;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Tests\TestCase;

class ResumeControllerTest extends TestCase
{
    // use DatabaseTransactions;

    /**
     * A basic feature test example.
     */
    public function  test_upload(): void
    {

        try{
            // Créer un utilisateur et se connecter
            $user = $this->createUser(2);


            $file = new UploadedFile(
                base_path('tests/files/resume.pdf'),
                'resume.pdf',
                'application/pdf',
                null,
                false
            );


            $response = $this->actingAs($user, 'api')->post(route('resumes.upload'), [
                'name' => 'test 1',
                'media' => [$file], // nom de la collection
            ]);

            dd($response->json());
            $response->assertStatus(200);

            $response->assertStatus(ResponseAlias::HTTP_OK);
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

}
