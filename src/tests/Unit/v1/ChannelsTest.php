<?php

namespace Tests\Unit\v1;

use App\Http\Controllers\API\V1\Channel\ChannelsController;
use App\Models\Channel;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ChannelsTest extends TestCase
{
    use RefreshDatabase;

    public function testGetAllChannels()
    {
        $channels =Channel::factory(10)->create();

        $response = $this->get(route('channels.list'));
        $response->assertStatus(200);
        $response->assertJsonCount(10);
    }

    public function testCreateNewChannelWithIncorrectData()
    {
        $response = $this->postJson(route('channels.create'));
        $response->assertStatus(422);
    }

    public function testCreateNewChannelWithCorrectData()
    {
        $user = User::factory()->create();

        $response = $this->postJson(route('channels.create'),[
            'name' => 'NewChannelTest',
            'user_id' => $user->id
        ]);
        $response->assertStatus(201);
    }

    public function testUpdateChannelInfoWithTrueData()
    {
        $channel = Channel::factory()->create();

        $response = $this->putJson(route('channels.update'),[
            'id' => $channel->id,
            'name' => 'New Name Test'
        ]);

        $updatedChannel = Channel::find($channel->id);
        $this->assertEquals($updatedChannel->name, 'New Name Test');
        $response->assertStatus(200);
    }

    public function testDeleteChannel()
    {
        $channel = Channel::factory()->create();

        $response = $this->deleteJson(route('channels.delete'),[
            'id' => $channel->id,
        ]);

        $response->assertStatus(200);
    }

//    public function testGetOwnChannelWithSlug()
//    {
//        $channel = Channel::factory()->create();
//
//        $response = $this->getJson(route('channels.one'),[
//            'slug' => $channel->slug
//        ]);
//
//        $response->assertStatus(200);
//    }

}
