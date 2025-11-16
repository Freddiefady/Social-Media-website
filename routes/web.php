<?php

declare(strict_types=1);

use App\Http\Controllers\Comments\CommentController;
use App\Http\Controllers\Comments\CommentReactionController;
use App\Http\Controllers\FollowerController;
use App\Http\Controllers\Global\SearchController;
use App\Http\Controllers\Group\ApprovedRequestController;
use App\Http\Controllers\Group\ChangeRoleController;
use App\Http\Controllers\Group\DestroyUserController;
use App\Http\Controllers\Group\GroupController;
use App\Http\Controllers\Group\InviteController;
use App\Http\Controllers\Group\JoinController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Post\UrlPreviewController;
use App\Http\Controllers\Posts\GeneratePostController;
use App\Http\Controllers\Posts\PostAttachmentController;
use App\Http\Controllers\Posts\PostController;
use App\Http\Controllers\Posts\PostReactionController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('/search/{search}', SearchController::class)->name('search');

Route::get('/u/{user:username}', [ProfileController::class, 'index'])
    ->name('profile');

Route::apiResource('group', GroupController::class)->except('index');

Route::get('/group/approve-invitation/{token}', ApprovedRequestController::class)
    ->name('group.approve');

Route::middleware('auth')->group(function (): void {
    Route::post('/profile/update-images', [ProfileController::class, 'updateImages'])
        ->name('profile.updateImages');
    //     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ----- Posts -----
    Route::apiResource('/post', PostController::class)
        ->except('index');

    Route::prefix('post')->group(function (): void {
        Route::name('post.')->group(function (): void {
            Route::get('/download/{attachment}', PostAttachmentController::class)->name('download');
            Route::post('/{post}/reaction', PostReactionController::class)->name('reaction');
            Route::post('/generate-post', GeneratePostController::class)->name('generate.ai');
            Route::post('/url-preview', UrlPreviewController::class)->name('url-preview');
        });

        Route::controller(CommentController::class)->name('comment.')->group(function (): void {
            Route::post('/{post}/comment', 'store')->name('store');
            Route::put('/comment/{comment}', 'update')->name('update');
            Route::delete('/comment/{comment}', 'destroy')->name('destroy');
            Route::post('/comment/{comment}/reaction', CommentReactionController::class)
                ->name('reaction');
        });
    });

    // ----- Groups -----
    Route::prefix('/group')->name('group.')->group(function (): void {
        Route::post('/update-images/{group}', [GroupController::class, 'updateImages'])
            ->name('update-images');

        Route::post('/invite/{group}', InviteController::class)
            ->name('invite');

        Route::post('/join/{group}', JoinController::class)
            ->name('join');

        Route::post('/approve/{group}', ApprovedRequestController::class)
            ->name('approve-request');

        Route::delete('/destroy-user/{group}', DestroyUserController::class)
            ->name('destroy-user');

        Route::post('/change-role/{group}', ChangeRoleController::class)
            ->name('change-role');
    });

    // ------ followers -----
    Route::post('/user/follower/{user}', FollowerController::class)
        ->name('user.follower');
});

require __DIR__.'/auth.php';
