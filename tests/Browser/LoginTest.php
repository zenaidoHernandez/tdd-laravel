<?php

namespace Tests\Browser;

use App\User;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class LoginTest extends DuskTestCase
{
    use DatabaseMigrations;
    /**
     * A Dusk test example.
     *
     * @test
     */
    public function registeredUserCanLogin()
    {
        factory(User::class)->create([
            'email' => 'zenaido@gmail.com'
        ]);

        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->type('email','zenaido@gmail.com')
                    ->type('password','password')
                    ->press('.btn.btn-primary')
                    ->assertPathIs('/')
                    ->assertAuthenticated();
        });
    }
}
