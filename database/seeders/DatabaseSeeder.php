<?php

namespace Database\Seeders;

use App\Models\Channel;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
//        $users = User::all()->pluck('id')->chunk(2)->toArray();
//        foreach ($users as $user) {
//            $channel = Channel::factory()->create();
//            foreach ($user as $id) {
//                Conversation::factory()->create(['user_id' => $id, 'channel_id' => $channel->id]);
//            }
//        }
//
//        for ($i = 0; $i < 1000; $i++) {
//            Message::factory()->create();
//        }
//
//        echo '================' . PHP_EOL;
//        echo round(microtime(true) - LARAVEL_START, 3) . 's' . PHP_EOL;
//        echo '================' . PHP_EOL;

//========================================================================

//        $users = DB::table('users')->get();
//
//        foreach ($users as $user) {
//            $random = $this->randomSelection($users->pluck('id')->toArray(), 6);
//            foreach ($random as $item => $value) {
//                if ($value != $user->id) {
//                    Friend::factory()->create(
//                        [
//                            'user_id'   => $user->id,
//                            'friend_id' => $value
//                        ]
//                    );
//                }
//            }
//        }


//        for ($i = 0; $i < 100; $i++) {
//            Profile::factory(10000)->create();
//        }

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }

    public function randomSelection($array, $count)
    {
        $keys = array_rand($array, $count);
        $result = [];
        foreach ($keys as $key) {
            $result[] = $array[$key];
        }
        return $result;
    }
}
