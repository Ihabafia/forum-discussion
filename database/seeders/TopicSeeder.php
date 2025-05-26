<?php

namespace Database\Seeders;

use App\Models\Topic;
use Illuminate\Database\Seeder;

class TopicSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'slug' => 'laravel',
                'title' => 'Laravel',
            ],
            [
                'slug' => 'inertia',
                'title' => 'Inertia',
            ],
            [
                'slug' => 'vue',
                'title' => 'Vue',
            ],
            [
                'slug' => 'livewire',
                'title' => 'Livewire',
            ],
        ];

        Topic::upsert($data, ['slug']);
    }
}
