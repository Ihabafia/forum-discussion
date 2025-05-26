<?php

namespace App\Http\Controllers;

use App\Facades\Helpers;
use App\Http\Resources\DiscussionResource;
use App\Http\Resources\PostResource;
use App\Models\Discussion;
use App\Models\Post;
use Illuminate\Http\Request;

class DiscussionShowController extends Controller
{
    public function __invoke(Request $request, Discussion $discussion)
    {
        if ($postId = $request->query('post')) {
            return redirect()->route('discussion.show', [
                'discussion' => $discussion,
                'page' => Helpers::getPageForPost($discussion, $postId),
                'postId' => $postId,
            ]);
        }

        $discussion->load(['topic', 'solution']);
        $discussion->loadCount('replies');

        return inertia('Discussion/Show', [
            'query' => (object) $request->query(),
            'discussion' => fn () => DiscussionResource::make($discussion),
            'posts' => fn () => PostResource::collection(
                Post::whereBelongsTo($discussion)
                    ->with(['user', 'discussion'])
                    ->oldest()
                    ->paginate(config('forum.pagination.per_page')),
            ),
            'postId' => (int) $request->postId,
        ]);
    }
}
