<?php

namespace App\Http\Controllers\API;

use App\Models\Post;
use App\Models\User;

use Illuminate\Support\Facades\Redis;

/**
 * @method sendResponse($array, string $string)
 */
class PostController extends AppBaseController
{
    public function index()
    {
        /** @var User $user */
        $user = auth('api')->user();
        $friends = $user->friends->pluck('id');

        $posts = [];
        foreach ($friends as $friend) {
            $friendPosts = $this->getFriendsPosts($friends, $friend);
            $posts = array_merge($posts, json_decode($friendPosts));
        }

        $posts = collect($posts)->sortByDesc('created_at');

        return $this->sendResponse(
            $posts,
            'Successfully.'
        );
    }

    protected function getFriendsPosts($friends, $friendId)
    {
        $chunk = ceil(1000 / count($friends));
        $cacheKeyPosts = 'cached_posts.' . $friendId;
        Redis::del($cacheKeyPosts);
        /** @var Redis $posts */
        $posts = Redis::get($cacheKeyPosts);
        if ($posts === null) {
            $posts = Post::query()->where('user_id', $friendId)
                ->with(['user' => fn($query) => $query->select('id', 'first_name', 'last_name')])
                ->limit($chunk)
                ->get();

            Redis::set($cacheKeyPosts, $posts);

            return json_encode($posts);
        }

        return $posts;
    }
}
