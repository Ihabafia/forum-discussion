<?php

namespace App\Http\Requests;

use App\Models\Discussion;
use App\Models\Topic;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreDiscussionRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'body' => ['required', 'string'],
            'topic_id' => ['required', Rule::exists(Topic::class, 'id')],
        ];
    }

    public function authorize(): bool
    {
        return auth()->user()->can('create', Discussion::class);
    }
}
