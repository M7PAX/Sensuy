<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\CommunityController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\VoteController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'home'])->name('home');
Route::get('/s/{slug}', [CommunityController::class, 'show'])->name('communities');
Route::get('/s/{community_slug}/{post:slug}', [PostController::class, 'show'])->name('posts');
Route::post('/s/{community_slug}/{post:slug}/comments', [CommentController::class, 'store'])->name('comments');
Route::get('/download/{file}', [FileController::class, 'download'])->name('download');

Route::group(['middleware' => ['auth', 'verified']], function () {
    Route::resource('/communities', CommunityController::class);
    Route::resource('/communities.posts', PostController::class);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::patch('/settings', [SettingsController::class, 'update'])->name('settings.update');

    Route::post('/{post:slug}/upVote', [VoteController::class, 'upVote'])->name('posts.upVote');
    Route::post('/{post:slug}/downVote', [VoteController::class, 'downVote'])->name('posts.downVote');
});

//Route::post('/set-locale', function () {
//    $locale = request('locale');
//    if (in_array($locale, ['en', 'lv', 'ru'])) {
//        session(['locale' => $locale]);
//        app()->setLocale($locale);
//    }
//    return response()->noContent();
//})->name('set.locale');

require __DIR__.'/auth.php';
