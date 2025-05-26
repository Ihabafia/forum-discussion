<?php

use App\Models\Discussion;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->nullable()->constrained('users')->nullOnDelete();
            $table->foreignIdFor(Discussion::class)->constrained('discussions')->cascadeOnDelete();
            $table->foreignIdFor(Post::class, 'parent_id')->nullable()->constrained('posts');
            $table->longText('body');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
