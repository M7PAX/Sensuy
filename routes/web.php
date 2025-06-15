<?php

use App\Http\Controllers\AIController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CommunityController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\VoteController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'home'])->name('home');
Route::get('/s/{community}', [CommunityController::class, 'show'])->name('communities');
Route::get('/s/{community}/{post:slug}', [PostController::class, 'show'])->name('posts');
Route::post('/s/{community}/{post:slug}/comments', [CommentController::class, 'store'])->name('comments');
Route::get('/download/{file}', [FileController::class, 'download'])->name('download');

Route::get('/sort', [HomeController::class, 'sortCommunities'])->name('sort-communities');
Route::get('/search', [SearchController::class, 'search'])->name('search');

Route::get('/load-posts', [HomeController::class, 'loadPosts'])->name('load-posts');
Route::get('/load-posts/{community:slug}', [CommunityController::class, 'loadMore'])->name('load-community-posts');

Route::group(['middleware' => ['auth', 'verified']], function () {
    Route::post('/communities/{community:slug}/update', [CommunityController::class, 'update'])->name('communities.update');
    Route::post('/communities/create', [CommunityController::class, 'store'])->name('communities.store');

    Route::resource('/communities', CommunityController::class)->except(['update', 'store']);
    Route::resource('/communities.posts', PostController::class);
    Route::resource('/communities.posts.comments', CommentController::class)->except(['show', 'create', 'index']);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::patch('/settings', [SettingsController::class, 'update'])->name('settings.update');

    Route::post('/{post:slug}/upVote', [VoteController::class, 'upVote'])->name('posts.upVote');
    Route::post('/{post:slug}/downVote', [VoteController::class, 'downVote'])->name('posts.downVote');
    Route::post('/{post:slug}/removeVote', [VoteController::class, 'removeVote'])->name('posts.removeVote');

    Route::post('/s/{community:slug}/follow', [FollowController::class, 'follow'])->name('communities.follow');
    Route::delete('/s/{community:slug}/unfollow', [FollowController::class, 'unfollow'])->name('communities.unfollow');

    Route::post('/ai', [AIController::class, 'sendMessage'])->middleware('auth');
});

require __DIR__.'/auth.php';
