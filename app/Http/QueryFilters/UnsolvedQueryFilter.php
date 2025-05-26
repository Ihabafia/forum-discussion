<?php

namespace App\Http\QueryFilters;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class UnsolvedQueryFilter implements Filter
{
    public function __invoke(Builder $query, mixed $value, string $property): void
    {
        if ($property !== 'unsolved' || ! auth()->user()) {
            return;
        }

        $query->whereNull('solution_post_id');
    }
}
