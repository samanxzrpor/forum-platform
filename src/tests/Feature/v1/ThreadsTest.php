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

        $response = $this->getJson(route('thread.show' , [$thread->slug]));

        $response->assertStatus(200);
        $this->assertSame($response->json()['body'] , $thread->body);
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


    public function testUpdateThreadWithCorrectData()
    {
        $user = User::factory()->create();
        $thread = Thread::factory()->create(['user_id' => $user->id]);
        Sanctum::actingAs($user);
        $response = $this->putJson(route('thread.update',[$thread]),[
            'title' => 'test updated thread',
            'channel_id' => $thread->channel_id
        ]);

        $response->assertStatus(200);
    }


    public function testCheckAuthrizationUserForUpdateThread()
    {
        $user = User::factory()->create();
        $thread = Thread::factory()->create();
        Sanctum::actingAs($user);
        $response = $this->putJson(route('thread.update', [$thread]),[

            'title' => 'test updated thread',
            'channel_id' => $thread->channel_id
        ]);

        $response->assertStatus(403);
    }

    public function testUpdateBestAnswerId()
    {
        $user = User::factory()->create();
        $thread = Thread::factory()->create(['user_id' => $user->id]);
        Sanctum::actingAs($user);
        $response = $this->putJson(route('thread.update',[$thread]),[
            'best_answer_id' => 8,
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('threads' , ['best_answer_id' => 8]);
    }

    public function testDeleteThreads()
    {
        $user = User::factory()->create();
        $thread = Thread::factory()->create(['user_id' => $user->id]);
        Sanctum::actingAs($user);
        $response = $this->deleteJson(route('thread.delete',['id' => $thread->id]));

        $response->assertStatus(200);
        $this->assertDatabaseMissing('threads' , ['slug' => $thread->slug]);
    }
}
