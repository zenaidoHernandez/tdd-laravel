<?php

namespace Tests\Browser;

use App\User;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UsersCanCreateStatusesTest extends DuskTestCase
{
    use DatabaseMigrations;
    /**
     * A Dusk test example.
     *
     * @test
     */
    public function userCanCreateStatuses()
    {
        $user = factory(User::class)->create();

        $this->browse(function (Browser $browser) use($user) {
            $browser->loginAs($user)
                    ->visit('/')
                    ->type('body', 'Mi primer status')
                    ->press('#create-status')
                    ->screenshot('create-status')
                    ->assertSee('Mi primer status');
        });
    }
}
