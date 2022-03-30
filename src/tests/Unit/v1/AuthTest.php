<?php

namespace Tests\Unit\v1;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class AuthTest extends TestCase
{

    use RefreshDatabase;

    public function registerRolesAndPermissions()
    {
        if (Role::where('name' , config('permission.default_roles')[0])->count() < 1) {

            foreach (config('permission.default_roles') as $role) {
                Role::create([
                    'name' => $role
                ]);
            }
        }

        if (Permission::where('name' , config('permission.default_permissions')[0])->count() < 1) {

            foreach (config('permission.default_permissions') as $permission) {
                Permission::create([
                    'name' => $permission
                ]);
            }
        }
    }

    public function testRegisterShouldBeValidate()
    {
        $this->registerRolesAndPermissions();
        $response = $this->postJson(route('auth.register'));
        $response->assertStatus(422);
    }

    public function testRegisterWithTrueCredentials()
    {
        $this->registerRolesAndPermissions();
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
