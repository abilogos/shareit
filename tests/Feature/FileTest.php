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
     * test file upload validations
     *
     * @return void
     */
    public function testUserUploadFileValidations()
    {
        Storage::fake('test_share');

        //testing size validation rule
        $bigFile = UploadedFile::fake()->create('big_file', 100000, 'image/jpeg');
        $response = $this->authenticate()->post(route('file.store'), ['file' => $bigFile]);
        $response->assertStatus(302);
        //Storage::disk('test_share')->assertMissing($bigFile->hashName());

        //testing notin mime rule
        $forbiddenMimes = [
            'php' => 'application/x-php',
            'bmp' => 'image/bmp',
            'exe' => 'application/x-msdownload',

        ];

        $forbiddenFiles =array();
        foreach ($forbiddenMimes as $extention => $mime) {
            $forbiddenFile = UploadedFile::fake()->create('danger.'.$extention, 10, $mime);
            $response = $this->post(route('file.store'), ['file' => $forbiddenFile]);
            $response->assertStatus(302);
            //Storage::disk('test_share')->assertMissing($forbiddenFile->hashName());
        }

        //passing test file
        $goodFile = UploadedFile::fake()->create('normal.jpeg', 5000, 'image/jpeg');
        $response = $this->authenticate()->post(route('file.store'), ['file' => $goodFile]);
        $response->assertStatus(200);
        //Storage::disk('test_share')->assertExists($goodFile->hashName());
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
}
