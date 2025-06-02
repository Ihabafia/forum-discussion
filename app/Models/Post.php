<?php

namespace App\Models;

use App\Observers\PostObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laravel\Scout\Searchable;

#[ObservedBy([PostObserver::class])]
class Post extends Model
{
    use HasFactory;
    use Searchable;

    public function toSearchableArray(): array
    {
        return $this->only('id', 'body');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function discussion(): BelongsTo
    {
        return $this->belongsTo(Discussion::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Post::class, 'parent_id');
    }

    public function mentions()
    {
        return $this->belongsToMany(User::class, 'mentions', 'post_id')
            ->withTimestamps();
    }
}
