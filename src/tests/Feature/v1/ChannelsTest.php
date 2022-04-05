<?php

namespace Tests\Feature\v1;

use App\Models\Channel;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;
use function config;
use function route;

class ChannelsTest extends TestCase
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

    public function testGetAllChannels()
    {
        $channels =Channel::factory(10)->create();

        $response = $this->get(route('channels.list'));
        $response->assertStatus(200);
        $response->assertJsonCount(10);
    }

    public function testCreateNewChannelWithIncorrectData()
    {
        $this->registerRolesAndPermissions();
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $user->givePermissionTo('channel management');

        $response = $this->postJson(route('channels.create'));
        $response->assertStatus(422);
    }

    public function testCreateNewChannelWithCorrectData()
    {
        $this->registerRolesAndPermissions();
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $user->givePermissionTo('channel management');

        $response = $this->postJson(route('channels.create'),[
            'name' => 'NewChannelTest',
            'user_id' => $user->id
        ]);
        $response->assertStatus(201);
        $this->assertDatabaseHas('channels' , ['name'=>'NewChannelTest']);

    }

    public function testUpdateChannelInfoWithTrueData()
    {
        $this->registerRolesAndPermissions();
        $channel = Channel::factory()->create();
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $user->givePermissionTo('channel management');

        $response = $this->putJson(route('channels.update'),[
            'id' => $channel->id,
            'name' => 'New Name Test'
        ]);

        $updatedChannel = Channel::find($channel->id);
        $this->assertEquals($updatedChannel->name, 'New Name Test');
        $response->assertStatus(200);
        $this->assertDatabaseHas('channels' , ['name'=>'New Name Test']);
    }

    public function testDeleteChannel()
    {
        $this->registerRolesAndPermissions();
        $channel = Channel::factory()->create();
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $user->givePermissionTo('channel management');

        $response = $this->deleteJson(route('channels.delete'),[
            'id' => $channel->id,
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseMissing('channels' , ['id'=>$channel->id , 'name' => $channel->name]);
    }


}
