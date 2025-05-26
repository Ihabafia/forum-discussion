<?php

namespace Database\Factories;

use App\Models\Discussion;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class DiscussionFactory extends Factory
{
    protected $model = Discussion::class;

    public function definition(): array
    {
        return [
            'title' => $title = $this->faker->realText(100),
            'slug' => str($title)->slug(),
            'user_id' => User::factory(),
            'topic_id' => Topic::factory(),

            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
