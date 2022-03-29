<?php

namespace Tests\Unit\v1;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{

    use RefreshDatabase;

    public function testRegisterShouldBeValidate()
    {
        $response = $this->postJson(route('auth.register'));
        $response->assertStatus(422);
    }

    public function testRegisterWithTrueCredentials()
    {
        $response = $this->postJson(route('auth.register'),[
            'name' => 'Mohammad',
            'email' => 'xzrpor@gmail.com',
            'password' => 'sam_1144'
        ]);
        $response->assertStatus(201);
    }

    public function testIncorrectCreditionLogin()
    {
        $response = $this->postJson(route('auth.login'));

        $response->assertStatus(422);
    }

    public function testLoginWithTrueCredentials()
    {
        $user = User::factory()->create();

        $response = $this->postJson(route('auth.login') , [
            'email' => $user->email,
            'password' => 'password'
        ]);

        $response->assertStatus(200);
    }

    public function testLogout()
    {
        $user = User::factory()->create();
        $this->actingAs($user)->postJson(route('auth.logout'));

        $this->assertGuest();
    }

    public function testGetUserLogined()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->postJson(route('auth.user'));

        $response->assertStatus(200);
    }
}