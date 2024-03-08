<?php

namespace App\Jobs;

use App\Helpers\AMQPHelper;
use App\Helpers\CacheHelper;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class UserPostsCachingJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;

    public function __construct($user)
    {
        $this->user = $user;
        $this->onQueue('posts_caching');
    }

    public function handle(): void
    {
        CacheHelper::setPostCache($this->user->id);

        foreach ($this->user->friends as $friend) {
            $message = 'Задача на уведомление пользователю ' . $friend->email . ' отправлена в очередь RabbitMQ';
            $queue = 'user_notifications_' . $friend->id;
            $routingKey = $queue;
            AMQPHelper::sendMessage($queue, $message, $routingKey);
            Log::info($message);
        }
    }
}
