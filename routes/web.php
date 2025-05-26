<?php

use App\Http\Controllers\DiscussionBestAnswerController;
use App\Http\Controllers\DiscussionDestroyController;
use App\Http\Controllers\DiscussionShowController;
use App\Http\Controllers\DiscussionStoreController;
use App\Http\Controllers\ForumIndexController;
use App\Http\Controllers\MarkdownPreviewController;
use App\Http\Controllers\PostDestroyController;
use App\Http\Controllers\PostStoreController;
use App\Http\Controllers\PostUpdateController;
use Illuminate\Support\Facades\Route;

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';

Route::get('dashboard', ForumIndexController::class)->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/', ForumIndexController::class)->name('home');
Route::get('/{discussion:slug}', DiscussionShowController::class)->name('discussion.show');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::post('discussions', DiscussionStoreController::class)->name('discussions.store');
    Route::delete('discussions/{discussion}', DiscussionDestroyController::class)->name('discussions.destroy');
    Route::post('discussions/{discussion}/posts', PostStoreController::class)->name('posts.store');
    Route::patch('posts/{post}', PostUpdateController::class)->name('posts.update');
    Route::delete('posts/{post}', PostDestroyController::class)->name('posts.destroy');
    Route::patch('best-answer/{discussion}', DiscussionBestAnswerController::class)->name('best-answer.patch');
    Route::post('markdown-preview', MarkdownPreviewController::class)->name('markdown-preview');
});
