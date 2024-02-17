<?php

namespace Database\Seeders;

use App\Models\Friend;
use App\Models\Post;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $users = DB::table('users')->get();

        foreach ($users as $user) {
            $random = $this->randomSelection($users->pluck('id')->toArray(), 6);
            foreach ($random as $item => $value) {
                if ($value != $user->id) {
                    Friend::factory()->create(
                        [
                            'user_id'   => $user->id,
                            'friend_id' => $value
                        ]
                    );
                }
            }
        }


//        for ($i = 0; $i < 100; $i++) {
//            Profile::factory(10000)->create();
//        }

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }

    public function randomSelection($array, $count) {
        $keys = array_rand($array, $count);
        $result = [];
        foreach ($keys as $key) {
            $result[] = $array[$key];
        }
        return $result;
    }
}
