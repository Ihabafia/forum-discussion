<?php

namespace Database\Seeders;

use App\Models\Discussion;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Database\Seeder;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(TopicSeeder::class);
        // User::factory(10)->create();

        $user = User::factory()->create([
            'username' => 'testuser',
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
        $users = User::all();

        $topics = Topic::all();

        Discussion::factory()->count(10)
            ->recycle($users)
            ->recycle($topics)
            ->create();

    }
}
