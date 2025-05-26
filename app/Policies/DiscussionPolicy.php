<?php

namespace App\Policies;

use App\Models\Discussion;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DiscussionPolicy
{
    use HandlesAuthorization;

    public function create(User $user): bool
    {
        return auth()->check();
    }

    public function reply(User $user, Discussion $discussion): bool
    {
        return auth()->check();
    }

    public function delete(User $user, Discussion $discussion): bool
    {
        return $user->id === $discussion->user_id && $discussion->created_at->gt(now()->subHour());
    }

    public function solve(User $user, Discussion $discussion): bool
    {
        return $user->id === $discussion->user_id /*&&
            $discussion->solution_post_id === null*/;
    }
}
