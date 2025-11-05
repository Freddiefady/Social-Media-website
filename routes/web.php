<?php

declare(strict_types=1);

use App\Http\Controllers\Comments\CommentController;
use App\Http\Controllers\Comments\CommentReactionController;
use App\Http\Controllers\Group\GroupController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Posts\PostAttachmentController;
use App\Http\Controllers\Posts\PostController;
use App\Http\Controllers\Posts\PostReactionController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('/u/{user:username}', [ProfileController::class, 'index'])
    ->name('profile');

Route::apiResource('group', GroupController::class)->except('index');

Route::get('/group/approve-invitation/{token}', [GroupController::class, 'AcceptInvitation'])
    ->name('group.approve');

Route::middleware('auth')->group(function () {
    Route::post('/profile/update-images', [ProfileController::class, 'updateImages'])
        ->name('profile.updateImages');
    //     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('/post', PostController::class)
        ->only(['store', 'update', 'destroy']);

    Route::prefix('post')->group(function () {
        Route::name('post.')->group(function () {
            Route::get('/download/{attachment}', PostAttachmentController::class)->name('download');
            Route::post('/{post}/reaction', PostReactionController::class)->name('reaction');
        });

        Route::controller(CommentController::class)->name('comment.')->group(function () {
            Route::post('/{post}/comment', 'store')->name('store');
            Route::put('/comment/{comment}', 'update')->name('update');
            Route::delete('/comment/{comment}', 'destroy')->name('destroy');
            Route::post('/comment/{comment}/reaction', CommentReactionController::class)
                ->name('reaction');
        });
    });
//----- Groups -----
    Route::post('/group/update-images/{group}', [GroupController::class, 'updateImages'])
        ->name('group.update-images');

    Route::post('/group/invite/{group}', [GroupController::class, 'invite'])
        ->name('group.invite');

    Route::post('/group/join/{group}', [GroupController::class, 'join'])
        ->name('group.join');

    Route::post('/group/approve/{group}', [GroupController::class, 'approveRequest'])
        ->name('group.approve-request');
});

require __DIR__.'/auth.php';
