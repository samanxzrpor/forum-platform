<?php

namespace Tests\Http\Controllers\API\V1\Channel;

use App\Http\Controllers\API\V1\Channel\ChannelsController;
use App\Models\Channel;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ChannelsControllerTest extends TestCase
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
}
