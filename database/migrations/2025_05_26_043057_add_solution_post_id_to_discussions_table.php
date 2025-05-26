<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('discussions', function (Blueprint $table) {
            $table->foreignId('solution_post_id')->nullable()->after('topic_id')->constrained('posts')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('discussions', function (Blueprint $table) {
            $table->dropForeign(['solution_post_id']);
            $table->dropColumn('solution_post_id');
        });
    }
};
