<?php

use App\Models\Topic;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('discussions', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->nullable()->constrained('users')->nullOnDelete();
            $table->foreignIdFor(Topic::class)->constrained('topics');
            $table->string('title');
            $table->string('slug')->unique()->nullable();

            $table->timestamp('pinned_at')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('discussions');
    }
};
