<?php

namespace App\Http\Controllers\API\V1\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{

    use RefreshDatabase;

    public function testRegisterShouldBeValidate()
    {
        $response = $this->postJson('http://localhost/api/v1/auth/register');
        $response->assertStatus(422);
    }

    public function testRegister()
    {
        $response = $this->postJson('http://localhost/api/v1/auth/register',[
            'name' => 'Mohammad',
            'email' => 'xzrpor@gmail.com',
            'password' => 'sam_1144'
        ]);
        $response->assertStatus(201);
    }
}
