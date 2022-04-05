<?php

namespace Tests\Feature\v1;

use App\Models\Answer;
use App\Models\Subscribe;
use App\Models\Thread;
use App\Models\User;
use App\Notifications\NewReplayThread;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class NotificationTest extends TestCase
{

    use RefreshDatabase;

    public function testSendNotification()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $thread = Thread::factory()->create();
        Notification::fake();

        $subscribe = Subscribe::factory()->create(['user_id' => $user->id , 'thread_id' => $thread->id]);
        $this->post(route('answers.store'),[
            'body' => 'Test Send Notification When Store Answer',
            'thread_id' => $thread->id
        ]);

        $response = $this->get(route('notifications'));
        dd($response->json());
//        $this->assertSame($response->json('notifications')['thread_title'] , $thread->title);
//        Notification::assertSentTo($user , NewReplayThread::class);
    }
}
