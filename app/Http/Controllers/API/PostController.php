<?php

namespace App\Http\Controllers\API;

use App\Models\Post;
use App\Models\User;

use Illuminate\Http\Request;
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
            $friendPosts = $this->getFriendsPosts($friend);
            $posts = array_merge($posts, json_decode($friendPosts));
        }

        $posts = collect($posts)->sortByDesc('created_at')->slice(0, 1000);

        return $this->sendResponse(
            $posts,
            'Successfully.'
        );
    }

    public function store(Request $request)
    {
        $user = auth('api')->user();
        $input = $request->validate(
            [
                'text' => ['required', 'string']
            ],
        );
        $post = $user->posts()
            ->create(
                ['text' => $input['text']]
            );

        if ($post) {
            $this->setPostCache($user);
        }

        return $this->sendResponse(
            $post,
            'Successfully saved.'
        );
    }

    protected function getFriendsPosts($friendId)
    {
        $cacheKey = 'cached_posts.' . $friendId;
//        Redis::del($cacheKey);
        /** @var Redis $posts */
        $posts = Redis::get($cacheKey);
        if ($posts === null) {
            $posts = Post::query()->where('user_id', $friendId)
                ->with(['user' => fn($query) => $query->select('id', 'first_name', 'last_name')])
                ->limit(200)
                ->get();

            Redis::set($cacheKey, $posts);

            return json_encode($posts);
        }

        return $posts;
    }

    protected function setPostCache($user): void
    {
        $cacheKey = 'cached_posts.' . $user->id;
        $posts = Post::query()->where('user_id', $user->id)
            ->with(['user' => fn($query) => $query->select('id', 'first_name', 'last_name')])
            ->orderBy('created_at', 'desc')
            ->limit(200)
            ->get();

        Redis::set($cacheKey, $posts);
    }
}
