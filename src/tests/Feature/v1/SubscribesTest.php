<?php

namespace Tests\Feature\v1;

use App\Models\Subscribe;
use App\Models\Thread;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;


class SubscribesTest extends TestCase
{

    public function testSubscribeThread()
    {
        $user = User::factory()->create();
        $thread = Thread::factory()->create();
        Sanctum::actingAs($user);

        $response = $this->post(route('subscribe' , [$thread]));
        $response->assertStatus(201);
        $this->assertDatabaseHas('subscribes' , ['thread_id' => $thread->id]);
    }

    public function testUnsubscribeThread()
    {
        $user = User::factory()->create();
        $thread = Thread::factory()->create();
        $subscribedThread = Subscribe::factory()->create([
            'thread_id' => $thread->id
        ]);
        Sanctum::actingAs($user);

        $response = $this->post(route('unsubscribe' , [$thread]));
        $response->assertStatus(200);
        $this->assertSame($response->json('message') , 'Thread Unsubscribe successfully');
    }
}
