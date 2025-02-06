<?php
use App\Http\Controllers\Backend\BCommunityController;
use App\Http\Controllers\Backend\BPostController;
use App\Http\Controllers\Backend\VoteController;
use App\Http\Controllers\Frontend\FCommunityController;
use App\Http\Controllers\Frontend\CommentController;
use App\Http\Controllers\Frontend\FPostController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'home'])->name('home');

Route::get('/s/{slug}', [FCommunityController::class, 'show'])->name('frontend.communities.show');
Route::get('/s/{community_slug}/posts/{post:slug}', [FPostController::class, 'show'])->name('frontend.communities.posts.show');
Route::post('/s/{community_slug}/posts/{post:slug}/comments', [CommentController::class, 'store'])->name('frontend.posts.comments');

Route::group(['middleware' => ['auth', 'verified']], function () {
    Route::resource('/communities', BCommunityController::class);
    Route::resource('/communities.posts', BPostController::class);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/posts/{post:slug}/upVote', [VoteController::class, 'upVote'])->name('posts.upVote');
    Route::post('/posts/{post:slug}/downVote', [VoteController::class, 'downVote'])->name('posts.downVote');
});

require __DIR__.'/auth.php';
