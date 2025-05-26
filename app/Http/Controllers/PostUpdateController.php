<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostUpdateRequest;
use App\Models\Post;

class PostUpdateController extends Controller
{
    public function __invoke(PostUpdateRequest $request, Post $post)
    {
        $post->update($request->validated());

        return back();
    }
}
