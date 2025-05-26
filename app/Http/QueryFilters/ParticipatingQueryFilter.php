<?php

namespace App\Http\QueryFilters;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class ParticipatingQueryFilter implements Filter
{
    public function __invoke(Builder $query, mixed $value, string $property): void
    {
        if (! auth()->user()) {
            return;
        }

        $query/* ->where('user_id', '!=', auth()->user()->id) */
            ->whereHas('posts', function (Builder $query) {
                $query->where('user_id', auth()->user()->id)
                    ->where('parent_id', '!=', null);
                //                $query->whereBelongsTo(auth()->user());
            });
    }
}
