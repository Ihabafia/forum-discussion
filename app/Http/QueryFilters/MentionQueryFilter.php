<?php

namespace App\Http\QueryFilters;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class MentionQueryFilter implements Filter
{
    public function __invoke(Builder $query, mixed $value, string $property): void
    {
        if (! auth()->user()) {
            return;
        }

        $query->whereHas('posts', function ($query) {
            $query->whereHas('mentions', function ($query) {
                $query->where('user_id', auth()->id());
            });
        });
    }
}
