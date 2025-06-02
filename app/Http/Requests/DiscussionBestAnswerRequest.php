<?php

namespace App\Http\Requests;

use App\Models\Post;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DiscussionBestAnswerRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'post_id' => ['nullable', Rule::exists(Post::class, 'id')],
        ];
    }

    public function authorize(): bool
    {
        return auth()->user()->can('solve', $this->discussion);
    }
}
