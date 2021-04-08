<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use \App\Models\User;

class AuthenticationTest extends DuskTestCase
{
    /**
     * we can be sure that registeration form is visible
     *
     * @return void
     */
    public function testUserCanViewRegisterationPage() :void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/register')
                    ->waitFor('form')
                    ->assertVisible('input#name')
                    ->assertVisible('input#email')
                    ->assertVisible('input#password')
                    ->assertVisible('input#password-confirm');
        });
    }

    /**
     * test for user which can view the login page
     *
     * @return void
     */
    public function testUserCanViewLoginPage() :void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->waitFor('form')
                    ->assertVisible('input#email')
                    ->assertVisible('input#password');
        });
    }

    /**
     * user can be loggin and redirect properly
     *
     * @return void
     */
    public function testUserLoggedInHomeView() :void
    {
        $user = User::factory()->create();

        $this->browse(function ($browser) use ($user) {
            $browser->visit('/login')
                    ->type('email', $user->email)
                    ->type('password', 'password')
                    ->press('Login')
                    ->assertPathIs('/home')
                    ->waitFor('.card-body')
                    ->assertVisible('#btn-file-create');
        });
    }


    /**
     * test in which user is authenticated and should be able to view registeration or login page
     *
     * @return void
     */
    public function testAuthenticatedCannotViewRegisterationOrLoginPage() :void
    {
        $user = User::factory()->create();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->visit('/login')
                ->assertPathIs('/home')
                ->visit('/register')
                ->assertPathIs('/home');
        });
    }
}
