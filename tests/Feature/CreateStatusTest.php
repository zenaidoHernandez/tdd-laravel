<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateStatusTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function guests_users_can_not_create_statuses(){
        $response = $this->post(route('statuses.store'), ['body' => 'Mi primer estado']);
        
        $response->assertRedirect('login');

    }

    /**
     * @test
     */
    public function anAuthenticatedUserCanCreateStatuses()
    {
        $this->withoutExceptionHandling();

        $user = factory(User::class)->create();
        $this->actingAs($user);

        $response = $this->postJson(route('statuses.store'), ['body' => 'Mi primer estado']);

        //$response->assertSuccessful();

        //$response->assertRedirect('/');

        $response->assertJson([
            'body' => 'Mi primer estado'
        ]);

        $this->assertDatabaseHas(
            'statuses',
            [
                'user_id' => $user->id,
                'body' => 'Mi primer estado',
            ]
        );

    }

    /**
     * @test
     */

     public function aStatusRequiresABody(){
         $user = factory(User::class)->create();
         $this->actingAs($user);

         $response = $this->postJson(route('statuses.store'),['body' => '']);

         //$response->assertSessionHasErrors('body');

         $response->assertStatus(422);

         $response->assertJsonStructure([
             'message', 'errors' => ['body']
         ]);

     }

     /**
     * @test
     */

     public function aStatusRequiresABodyMinFiveCharacters(){
        $user = factory(User::class)->create();
        $this->actingAs($user);

        $response = $this->postJson(route('statuses.store'),['body' => 'abcd']);

        //$response->assertSessionHasErrors('body');

        $response->assertStatus(422);

        $response->assertJsonStructure([
            'message', 'errors' => ['body']
        ]);

    }

}
