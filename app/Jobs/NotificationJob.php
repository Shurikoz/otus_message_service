<?php

namespace App\Jobs;

use App\Helpers\AMQPHelper;
use App\Mail\Notification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class NotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $users;

    public function __construct($users)
    {
        $this->users = $users;
        $this->onQueue('notification');
    }

    public function handle(): void
    {
        foreach ($this->users as $user) {
            $message = 'Задача на уведомление пользователю ' . $user->email . ' отправлена в очередь RabbitMQ';
            $queue = 'user_notifications_' . $user->id;
            $routingKey = $queue;
            AMQPHelper::sendMessage($queue, $message, $routingKey);
            Log::info($message);
        }
    }
}
