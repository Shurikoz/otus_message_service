<?php

namespace App\Http\Controllers\API;

use App\Models\Channel;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Tarantool\Client\Client;
use Tarantool\Client\Schema\Criteria;

class MessengerController extends AppBaseController
{

    public function messenger()
    {
        $users = User::all()->pluck('id')->chunk(2)->toArray();
        foreach ($users as $user) {
            $channel = Channel::factory()->create();
            foreach ($user as $id) {
                Conversation::factory()->create(['user_id' => $id, 'channel_id' => $channel->id]);
            }
        }

        for ($i = 0; $i < 1000; $i++) {
            Message::factory()->create();
        }

//        $client = Client::fromOptions(
//            [
//                'uri'      => 'tcp://127.0.0.1:3301',
//                'username' => 'admin',
//                'password' => 'pass',
//            ]
//        );
//        $messages = $client->getSpace('messages');
//        $result = $messages->select(
//            Criteria::index('secondary')
//                ->andKey(['CYPvNSv94pnw0flkdQZP6cVqs9JeTv0CVkuH6xAv'])
//                ->andLimit(10)
//                ->andOffset(0)
//        );
//
//        echo '================' . PHP_EOL;
//        echo printf(json_encode($result)) . PHP_EOL;
//        echo '================' . PHP_EOL;
//        echo round(microtime(true) - LARAVEL_START, 3) . 's' . PHP_EOL;
//        echo '================' . PHP_EOL;

        echo '================' . PHP_EOL;
        echo round(microtime(true) - LARAVEL_START, 3) . 's' . PHP_EOL;
        echo '================' . PHP_EOL;
    }

    public function channel()
    {
        $users = User::all()->pluck('id')->chunk(2)->toArray();
        foreach ($users as $user) {
            $channel = Channel::factory()->create();
            foreach ($user as $id) {
                Conversation::factory()->create(['user_id' => $id, 'channel_id' => $channel->id]);
            }
        }

        $time = round(microtime(true) - LARAVEL_START, 3) . 's';
        echo printf(json_encode($time)) . PHP_EOL;
    }

    public function postMessageInPostgres()
    {
        $timerStart = microtime(true);

        $conversation = Conversation::with('channels')->get();
        $data = [];
        for ($i = 0; $i < 2000; $i++) {
            $item = $conversation->random();
            $data[] = [
                'user_id'    => $item->user_id,
                'channel_id' => $item->channel_id,
                'text'       => Message::factory()->make()->text,
            ];
        }

        $timerGenerate = round(microtime(true) - $timerStart, 3) . 's';
        $timerInsert = microtime(true);

        foreach ($data as $item) {
            Message::query()->insert($item);
        }

        echo '================' . PHP_EOL;
        echo 'Время генерации данных: ' . $timerGenerate . 's' . PHP_EOL;
        echo '================' . PHP_EOL;
        echo 'Время вставки данных: ' . round(microtime(true) - $timerInsert, 3) . 's' . PHP_EOL;
        echo '================' . PHP_EOL;
    }

    public function postMessageInTarantool()
    {
       $timerStart = microtime(true);

        $client = Client::fromOptions(
            [
                'uri'      => 'tcp://127.0.0.1:3301',
                'username' => 'admin',
                'password' => 'pass',
            ]
        );
        $messages = $client->getSpace('messages');
        $conversation = Conversation::with('channels')->get();

        for ($i = 0; $i < 2000; $i++) {
            $item = $conversation->random();
            $data[] = [
                Str::random(60),
                $item->channels->name,
                $item->user_id,
                Message::factory()->make()->text,
                time()
            ];
        }

        $timerGenerate = round(microtime(true) - $timerStart, 3) . 's';
        $timerInsert = microtime(true);
        foreach ($data as $item) {
            $messages->insert($item);
        }

        echo '================' . PHP_EOL;
        echo 'Время генерации данных: ' . $timerGenerate . 's' . PHP_EOL;
        echo '================' . PHP_EOL;
        echo 'Время вставки данных: ' . round(microtime(true) - $timerInsert, 3) . 's' . PHP_EOL;
        echo '================' . PHP_EOL;
    }
}
