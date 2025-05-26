<?php

namespace App\Http\Controllers;

use App\Facades\Helpers;
use App\Http\Requests\DiscussionBestAnswerRequest;
use App\Models\Discussion;
use App\Models\Post;

class DiscussionBestAnswerController extends Controller
{
    public function __invoke(DiscussionBestAnswerRequest $request, Discussion $discussion)
    {
        $discussion->solution()->associate(Post::find($request->post_id));
        $discussion->save();

        return to_route('discussion.show', [
            'discussion' => $discussion,
            'page' => Helpers::getPageForPost($discussion, $request?->post_id),
            'postId' => $request->post_id,
        ]);
    }
}
