<?php

namespace App\Http\Resources;

use App\Models\Discussion;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Discussion */
class DiscussionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'is_pinned' => $this->isPinned(),
            // 'replies_count' => str($this->replies_count)->append(' ')->append(str('Reply')->plural($this->replies_count)),
            'replies_count' => $this->replies_count,
            'topic' => TopicResource::make($this->whenLoaded('topic')),
            'post' => PostResource::make($this->whenLoaded('post')),
            'solution' => PostResource::make($this->whenloaded('solution')),
            'latest_post' => PostResource::make($this->whenLoaded('latestPost')),
            'user' => UserResource::make($this->whenLoaded('user')),
            'participants' => UserResource::collection($this->whenLoaded('participants')),
            'user_can' => [
                'reply' => auth()->user()?->can('reply', $this->resource),
                'delete' => auth()->user()?->can('delete', $this->resource),
                'solve' => auth()->user()?->can('solve', $this->resource),
            ],

            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
