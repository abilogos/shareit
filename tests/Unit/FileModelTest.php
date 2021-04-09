<?php

namespace Tests\Unit;

//use PHPUnit\Framework\TestCase;
use Tests\TestCase;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use App\Models\File;
use App\Models\User;

class FileModelTest extends TestCase
{
    use RefreshDatabase;
    use HasFactory;

    /**
     * testcase for model creation.
     *
     * @return void
     */
    public function testFileModelCanBeSaved() : void
    {
        $file = $this->createFakeFileModel();
        $this->assertNotNull($file->id);
    }

    /**
     * This Module test that file shouldnt be created without a valid user
     *
     * @return void
     */
    public function testFileModelCouldntSaveWithoutAValidUser() : void
    {
        //suppose a non-existance user_id
        $this->assertNull(User::find(PHP_INT_MAX));
        $exception = null;
        //it should raise an exception (because of the foreign key integerity)
        try {
            $file = $this->createFakeFileModel(PHP_INT_MAX);
        } catch (\Illuminate\Database\QueryException $e) {
            $exception = $e;
        }
        $this->assertNotNull($exception);
    }

    /**
     * test for download_count initial value should be zero
     *
     * @return void
     */
    public function testInitiatedFileHasZeroDownloads() : void
    {
        $this->assertEquals($this->createFakeFileModel()->download_count, 0);
    }

    /**
     * This method will test if id and fakeid are convertable to each other or not
     * @return void
     */
    public function testFakeId() : void
    {
        $file = $this->createFakeFileModel();
        $id = $file->id;
        $fakeId = $file->getRouteKey();

        $this->assertNotEquals($fakeId, $id);
        // $file->resolveRouteBinding($fakeId) would retrive File Object
        $this->assertEquals($file->resolveRouteBinding($fakeId)->id, $id);
    }

    /**
     * This method will test hitDownload method
     *
     * @return void
     */
    public function testHitDownload() : void
    {
        $file = $this->createFakeFileModel();
        $this->assertEquals($file->download_count, 0);

        $file->hitDownload();
        $this->assertEquals($file->download_count, 1);

        $fakeDownloadCount = \random_int(0, 1000000);
        $file->download_count = $fakeDownloadCount;
        $file->hitDownload();
        $fakeDownloadCount++;
        $this->assertEquals($file->download_count, $fakeDownloadCount);
    }

    /**
     * this method will create a fake file model with given user_id
     *
     * @param integer userId
     * @return File created file model
     */
    private function createFakeFileModel($userId=null)
    {
        //if userId hasnt been passed, it will create one.
        $userId = $userId??User::factory()->create()->id;

        return File::factory()->create(['user_id' => $userId]);
    }
}
