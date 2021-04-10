<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use \App\Models\User;
use Illuminate\Support\Facades\Storage;

class FileTest extends TestCase
{
    use RefreshDatabase;

    /**
     * This Test Indicates Only Authenticated User can Access The File Uplaod Page
     */
    public function testAuthUserCanAccessUploadFilePage() : void
    {
        $response = $this->authenticate()->get(route('file.create'));
        $response->assertStatus(200);
    }

    /**
     * test file bigger than 10MB cannot be uploaded
     *
     * @return void
     */
    public function testUserCannotUploadBigFile() : void
    {
        $this->assertUploadFile('big_file', 100000, 'image/jpeg', false);
    }

    /**
     * test forbidden mimetypes shouldnt allowed to be uploaded
     *
     * @return void
     */
    public function testForbiddenMimeFileCannotUploaded() : void
    {
        //testing notin_mime rule
        $forbiddenMimes = [
            //forbiding based on mime types
            'php' => 'application/x-php',
            'bmp' => 'image/bmp',
            'exe' => 'application/x-msdownload',
            //also forbidding based on extention
            'php' => 'image/jpeg',
            'bmp' => 'image/png',
            'exe' => 'text/html',
        ];

        $forbiddenFiles =array();
        foreach ($forbiddenMimes as $extention => $mime) {
            $this->assertUploadFile('danger.'.$extention, 10, $mime, false);
        }
    }

    /**
     * test a valid file (size & mime) should be uploadable
     *
     * @return void
     */
    public function testValidFileUpload() : void
    {
        $this->assertUploadFile('normal.jpeg', 5000, 'image/jpeg', true);
    }

    /**
     * This Method will login as a just created user Using chaining methods
     *
     * @return File $this testcase class
     */
    private function authenticate()
    {
        $user = User::factory()->make();
        return $this->actingAs($user);
    }

    /**
     * This Method tests route('file.store') with a fake file and assertAllow
     *
     * This method gets attributes about a file and upload a fake file based on them
     * then make a file and upload in endpoint route('file.store') then observes
     * if file upload acceptance is like $expectedPermit or not.
     *
     * @param  string $fileName     name of the fake file
     * @param  integer $fileSize     file size in KB
     * @param  string $fileMime     indicate file mime type
     * @param  bool $expectedPermit expection about the endpoint that permits this file or not
     * @return void
     */
    private function assertUploadFile($fileName, $fileSize, $fileMime, $expectedPermit) : void
    {
        Storage::fake('test_share');
        $fakeFile = UploadedFile::fake()->create($fileName, $fileSize, $fileMime);
        $response = $this->authenticate()->post(route('file.store'), ['file' => $fakeFile]);

        //assertions are based on expectation
        if ($expectedPermit) {
            $response->assertStatus(200);
        //Storage::disk('test_share')->assertExists($fakeFile->hashName());
        } else {
            //redirect to file uploading page
            $response->assertStatus(302);
            //Storage::disk('test_share')->assertMissing($fakeFile->hashName());
        }
    }
}
