<?php

namespace App\Http\QueryFilters;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class SolvedQueryFilter implements Filter
{
    public function __invoke(Builder $query, mixed $value, string $property): void
    {
        if ($property !== 'solved' || ! auth()->user()) {
            return;
        }

        $query->whereNotNull('solution_post_id');
    }
}
