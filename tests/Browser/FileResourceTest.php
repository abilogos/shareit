<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use \App\Models\File;
use \App\Models\User;

class FileResourceTest extends DuskTestCase
{
    /**
     * we can be sure that upload form would accesible for an authenticated user.
     *
     * @return void
     */
    public function testUserCanViewFileUploadPage() :void
    {
        $user = User::factory()->create();

        $this->browse(function (Browser $browser) {
            $browser->visit(route('file.create'))
            ->assertPathIsNot(route('file.create'));
        });

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->visit(route('file.create'))
                ->waitFor('.form')
                ->assertVisible('#file-input');
        });
    }
}
