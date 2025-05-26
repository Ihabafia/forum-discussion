<?php

namespace App\Http\Resources;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;
use Spatie\LaravelMarkdown\MarkdownRenderer;

/** @mixin Post */
class PostResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'body' => $this->body,
            /*'body_markdown' => str($this->body)->markdown([
                'html_input' => 'strip',
                'allow_unsafe_links' => true,
                'allow_unsafe_protocols' => false,
                'max_nesting_level' => 5,
            ]),*/
            'discussion' => DiscussionResource::make($this->whenLoaded('discussion')),
            'body_markdown' => app(MarkdownRenderer::class)->toHtml($this->body),
            'body_preview' => Str::limit($this->body, 200, '...'),
            'user' => UserResource::make($this->whenLoaded('user')),
            'created_at' => DateTimeResource::make($this->created_at),
            'user_can' => [
                'edit' => auth()->user()?->can('update', $this->resource),
                'delete' => auth()->user()?->can('delete', $this->resource),
            ],
            //            'created_at' => $this->created_at,
            //            'updated_at' => $this->updated_at,
            //
            //            'user_id' => $this->user_id,
            //            'discussion_id' => $this->discussion_id,
            //            'parent_id' => $this->parent_id,
            //
            //            'user' => new UserResource($this->whenLoaded('user')),
            //            'discussion' => new DiscussionResource($this->whenLoaded('discussion')),
            //            'parent' => new PostResource($this->whenLoaded('parent')),
        ];
    }
}
