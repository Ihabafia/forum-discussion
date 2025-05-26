<?php

namespace App\Http\QueryFilters;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class MyDiscussionsQueryFilter implements Filter
{
    public function __invoke(Builder $query, mixed $value, string $property): void
    {
        if (! auth()->user()) {
            return;
        }

        $query->whereBelongsTo(auth()->user());
    }
}
