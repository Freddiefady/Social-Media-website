<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Posts\PostController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

     Route::get('/post/download/{attachment}', [PostController::class, 'downloadAttachment'])->name('post.download');
 });

require __DIR__.'/auth.php';
