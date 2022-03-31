<?php

namespace Tests\Feature\v1;

use App\Http\Controllers\API\V1\Thraed\ThreadsController;
use App\Models\Channel;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ThreadsTest extends TestCase
{
    use RefreshDatabase;


    public function testGetAllThreads()
    {
        $threads = Thread::factory(12)->create();
        $response = $this->getJson(route('thread.list'));
        $response->assertStatus(200);
    }

    public function testGetOneThreadWithSlug (){

        $thread = Thread::factory()->create();

        $response = $this->getJson(route('thread.show') , [
            'slug' => $thread->slug
        ]);

        $response->assertStatus(200);
//        $this->assertEquals($thread->name, $response->json());
    }

    public function testCreateNewThreadWithTrueData()
    {
        $channel = Channel::factory()->create();
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $response = $this->postJson(route('thread.store'),[
            'title' => 'New Thread Test For Laravel',
            'channel_id' => $channel->id,
            'body' => 'Hi This is New Thread About Laravel For Test'
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('threads' , ['title'=>'New Thread Test For Laravel']);
    }

    public function testCreateNewThreadWithNotTrueData()
    {
        $channel = Channel::factory()->create();
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $response = $this->postJson(route('thread.store'),[]);

        $response->assertStatus(422);
    }

    public function testDeleteThreads()
    {
        $thread = Thread::factory()->create();
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $response = $this->deleteJson(route('thread.delete'),['id' => $thread->id]);

        $response->assertStatus(200);
        $this->assertDatabaseMissing('threads' , ['slug' => $thread->slug]);
    }
}
