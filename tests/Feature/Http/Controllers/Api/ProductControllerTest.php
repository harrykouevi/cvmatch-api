<?php

namespace Tests\Feature\Http\Controllers\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;

use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function  test_index(): void
    {

        try{
            // Créer un utilisateur et se connecter

            $response = $this->getJson(route('credit-plans.index'));

            $response->assertStatus(200);
            $response->assertJsonStructure([
                'success',
                'data',
                'message',
            ]);

        } catch (\Exception $e) {
            Log::error('FAIL:'. $e->getMessage() , [
                 'trace' => $e->getTraceAsString()
            ]);
            throw $e ;
        }
    }
}
