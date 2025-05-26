<?php

namespace App\Http\Controllers;

use App\Http\Resources\DiscussionResource;
use App\Models\Discussion;
use Illuminate\Http\Request;

class DiscussionController extends Controller
{
    public function index()
    {
        return DiscussionResource::collection(Discussion::all());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => ['nullable', 'exists:users'],
            'topic_id' => ['required', 'exists:topics'],
            'title' => ['required'],
            'slug' => ['required'],
        ]);

        return new DiscussionResource(Discussion::create($data));
    }

    public function show(Discussion $discussion)
    {
        return new DiscussionResource($discussion);
    }

    public function update(Request $request, Discussion $discussion)
    {
        $data = $request->validate([
            'user_id' => ['nullable', 'exists:users'],
            'topic_id' => ['required', 'exists:topics'],
            'title' => ['required'],
            'slug' => ['required'],
        ]);

        $discussion->update($data);

        return new DiscussionResource($discussion);
    }

    public function destroy(Discussion $discussion)
    {
        $discussion->delete();

        return response()->json();
    }
}
