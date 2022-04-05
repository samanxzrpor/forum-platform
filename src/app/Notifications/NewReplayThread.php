<?php

namespace App\Notifications;

use App\Models\Thread;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewReplayThread extends Notification
{
    use Queueable;

    protected Thread $thread;


    public function __construct(Thread $thread)
    {
        $this->thread = $thread;
    }


    public function via($notifiable)
    {
        return ['database'];
    }


    public function toDatabase($notifiable)
    {
        return [
            'thread_title' => $this->thread->title,
            'thread_url' => route('threads.show' , [$this->thread->slug]),
            'date' => now()->format('Y-m-d H:i:s')
        ];
    }
}
