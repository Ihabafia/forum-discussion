<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Str;

class Discussion extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
    ];

    protected static function booted(): void
    {
        static::created(function (self $discussion) {
            $discussion->update(['slug' => $discussion->title]);
        });
    }

    public function setSlugAttribute($value): string
    {
        return $this->attributes['slug'] = $this->id.'-'.Str::slug($value);

        /*return Attribute::set(fn ($value) => [
            'slug' => $this->id.'-'.Str::slug($value),
        ]);*/
    }

    public function scopeOrderByPinned($query)
    {
        return $query->orderBy('pinned_at');
    }

    public function scopeOrderByLastPost($query)
    {
        return $query->orderByDesc(
            Post::select('created_at')->whereColumn('posts.discussion_id', 'discussions.id')
                ->latest()
                ->take(1)
        );
    }

    public function isPinned(): bool
    {
        return ! is_null($this->pinned_at);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function topic(): BelongsTo
    {
        return $this->belongsTo(Topic::class);
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    public function replies(): HasMany
    {
        return $this->hasMany(Post::class)
            ->whereNotNull('parent_id');
    }

    public function post(): HasOne|Post
    {
        return $this->hasOne(Post::class)
            ->whereNull('parent_id');
    }

    public function latestPost(): HasOne|Post
    {
        return $this->hasOne(Post::class)
            ->latestOfMany('created_at')
            ->whereNotNull('parent_id');
    }

    public function participants(): HasManyThrough
    {
        return $this->hasManyThrough(User::class, Post::class, 'discussion_id', 'id', 'id', 'user_id')
            ->distinct();
    }

    public function solution()
    {
        return $this->belongsTo(Post::class, 'solution_post_id');
    }

    protected function casts(): array
    {
        return [
            'pinned_at' => 'datetime',
        ];
    }
}
