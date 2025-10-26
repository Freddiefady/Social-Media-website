<?php

declare(strict_types=1);

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Posts\PostController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('/u/{user:username}', [ProfileController::class, 'index'])
    ->name('profile');

Route::middleware('auth')->group(function () {
    Route::post('/profile/update-images', [ProfileController::class, 'updateImages'])
        ->name('profile.updateImages');
    //     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('/post', PostController::class)
        ->only(['store', 'update', 'destroy']);

    Route::prefix('post')->controller(PostController::class)->name('post.')->group(function () {

        Route::get('/download/{attachment}', 'downloadAttachment')->name('download');

        Route::post('/{post}/reaction', 'postReaction')->name('reaction');

        Route::post('/{post}/comment', 'createComment')->name('comment.store');

        Route::delete('/comment/{comment}', 'destroyComment')->name('comment.destroy');

        Route::put('/comment/{comment}', 'updateComment')->name('comment.update');
    });
});

require __DIR__.'/auth.php';
