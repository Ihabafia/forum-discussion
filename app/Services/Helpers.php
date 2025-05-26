<?php

namespace App\Services;

use App\Models\Discussion;
use App\Models\Post;

class Helpers
{
    public function getPageForPost(Discussion $discussion, ?int $postId): int
    {
        $index = $discussion->posts->search(fn (Post $post) => $post->id === $postId);

        return (int) ceil(($index + 1) / config('forum.pagination.per_page'));
    }
}
