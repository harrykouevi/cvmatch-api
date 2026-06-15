<?php

namespace Tests\Feature\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Tests\TestCase;

/**
 * Covers upload validation rules in ResumeController::storeResumeWithMedia():
 *  - PDF accepted, DOCX accepted
 *  - legacy .doc (application/msword) rejected
 *  - files larger than 10 MB rejected
 *  - rejections return a clear JSON validation error (HTTP 422)
 *
 * Notes:
 *  - Accepted types use minimal REAL fictional fixtures (tests/Fixtures)
 *    so getMimeType() is stable and the PDF/Word extractor can parse them.
 *  - Rejected types use UploadedFile::fake() (no real content needed; the
 *    type/size rules run before extraction, so this is deterministic).
 *  - No real CV, no file-content logging, no extracted_text exposure.
 */
class ResumeUploadValidationTest extends TestCase
{
    use DatabaseTransactions;

    private const VISITOR_URL = '/api/v1/resumes/visitor-upload';
    private const AUTH_URL     = '/api/v1/resumes/upload';

    private function createUser(): User
    {
        return User::create([
            'name'       => Str::random(10),
            'email'      => Str::random(10) . '@example.com',
            'password'   => Hash::make('password125'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    // Real (but fictional, minimal) fixtures — stable mime + parseable.
    private function realPdf(): UploadedFile
    {
        return new UploadedFile(base_path('tests/Fixtures/sample.pdf'), 'cv.pdf', 'application/pdf', null, true);
    }

    private function realDocx(): UploadedFile
    {
        return new UploadedFile(
            base_path('tests/Fixtures/sample.docx'),
            'cv.docx',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            null,
            true
        );
    }

    // Fake files for rejection paths (validated before extraction).
    private function fakeDoc(): UploadedFile
    {
        return UploadedFile::fake()->create('cv.doc', 200, 'application/msword');
    }

    private function fakeOversizePdf(): UploadedFile
    {
        return UploadedFile::fake()->create('cv.pdf', 11 * 1024, 'application/pdf'); // 11 MB
    }

    private function assertRejected($response, string $needle): void
    {
        $response->assertStatus(422);
        $response->assertSee($needle);
    }

    // ----------------------------- GUEST -----------------------------

    public function test_guest_can_upload_pdf(): void
    {
        $response = $this->post(self::VISITOR_URL, [
            'name'  => 'guest pdf',
            'media' => [$this->realPdf()],
        ]);
        $response->assertStatus(200);
    }

    public function test_guest_can_upload_docx(): void
    {
        $response = $this->post(self::VISITOR_URL, [
            'name'  => 'guest docx',
            'media' => [$this->realDocx()],
        ]);
        $response->assertStatus(200);
    }

    public function test_guest_cannot_upload_doc(): void
    {
        $response = $this->post(self::VISITOR_URL, [
            'name'  => 'guest doc',
            'media' => [$this->fakeDoc()],
        ]);
        $this->assertRejected($response, 'Format de fichier non supporté');
    }

    public function test_guest_cannot_upload_file_larger_than_10mb(): void
    {
        $response = $this->post(self::VISITOR_URL, [
            'name'  => 'guest big',
            'media' => [$this->fakeOversizePdf()],
        ]);
        $this->assertRejected($response, '10 Mo');
    }

    // ------------------------- AUTHENTICATED -------------------------

    public function test_authenticated_user_can_upload_pdf(): void
    {
        $user = $this->createUser();
        $response = $this->actingAs($user, 'sanctum')->post(self::AUTH_URL, [
            'name'  => 'auth pdf',
            'media' => [$this->realPdf()],
        ]);
        $response->assertStatus(200);
    }

    public function test_authenticated_user_can_upload_docx(): void
    {
        $user = $this->createUser();
        $response = $this->actingAs($user, 'sanctum')->post(self::AUTH_URL, [
            'name'  => 'auth docx',
            'media' => [$this->realDocx()],
        ]);
        $response->assertStatus(200);
    }

    public function test_authenticated_user_cannot_upload_doc(): void
    {
        $user = $this->createUser();
        $response = $this->actingAs($user, 'sanctum')->post(self::AUTH_URL, [
            'name'  => 'auth doc',
            'media' => [$this->fakeDoc()],
        ]);
        $this->assertRejected($response, 'Format de fichier non supporté');
    }

    public function test_authenticated_user_cannot_upload_file_larger_than_10mb(): void
    {
        $user = $this->createUser();
        $response = $this->actingAs($user, 'sanctum')->post(self::AUTH_URL, [
            'name'  => 'auth big',
            'media' => [$this->fakeOversizePdf()],
        ]);
        $this->assertRejected($response, '10 Mo');
    }
}
