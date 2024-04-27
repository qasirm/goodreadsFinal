<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BookSearchController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FavoritesController;
use Illuminate\Support\Facades\Route;

// API route for toggling favorites
Route::post('/favorites/toggle', [FavoritesController::class, 'toggle'])->middleware('auth');



Route::get('/', [BookSearchController::class, 'search'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::post('/books/{id}/comments', [CommentController::class, 'store'])->name('comments.store');

Route::get('/favorites', [FavoritesController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('favorites');

Route::get('/books/{id}', [BookSearchController::class, 'show'])
    ->middleware(['auth', 'verified'])
    ->name('books.show');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::post('/friends/send', [FriendsController::class, 'sendRequest'])->name('friends.send');
Route::post('/friends/accept/{id}', [FriendsController::class, 'acceptRequest'])->name('friends.accept');
Route::get('/friends', [FriendsController::class, 'listFriends'])->name('friends.list');

Route::get('/nook/{userId}', [ProfileController::class, 'show'])->name('nook.show');




require __DIR__.'/auth.php';
