<?php

namespace App\Http\QueryFilters;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class TopicQueryFilter implements Filter
{
    public function __invoke(Builder $query, mixed $value, string $property): void
    {
        if ($property !== 'topic' || ! auth()->user()) {
            return;
        }

        $query->whereHas('topic', function (Builder $query) use ($value) {
            $query->where('slug', "$value");
        });
    }
}
