<?php

namespace App\Http\Controllers\API;

use App\Helpers\AMQPHelper;
use App\Helpers\CacheHelper;
use App\Jobs\NotificationJob;
use App\Jobs\UserPostsCachingJob;
use App\Models\Post;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

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
            dispatch(new UserPostsCachingJob($user));
        }

        return $this->sendResponse(
            $post,
            'Successfully saved.'
        );
    }

    public function posted(Request $request)
    {
        $input = $request->validate(
            [
                'id' => ['required', 'integer']
            ],
        );

        CacheHelper::setPostCache($input['id']);
    }

    protected function getFriendsPosts($friendId)
    {
        $cacheKey = 'cached_posts.' . $friendId;
//        Redis::del($cacheKey);
        /** @var Redis $posts */
        $posts = Redis::get($cacheKey);
        if ($posts === null) {
            return CacheHelper::setPostCache($friendId);
        }

        return $posts;
    }
}
