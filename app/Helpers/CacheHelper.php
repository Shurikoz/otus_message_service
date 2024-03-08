<?php

namespace App\Helpers;

use App\Models\Post;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;

class CacheHelper
{
    public static function setPostCache($userId): string
    {
        $cacheKey = 'cached_posts.' . $userId;
        $posts = Post::query()->where('user_id', $userId)
            ->with(['user' => fn($query) => $query->select('id', 'first_name', 'last_name')])
            ->orderBy('created_at', 'desc')
            ->limit(200)
            ->get();

        Redis::set($cacheKey, $posts);

        Log::info('Лента пользователя с id = ' . $userId . ' успешно кэширована');

        return json_encode($posts);
    }
}
