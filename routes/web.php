<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BookSearchController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FavoritesController;
use App\Http\Controllers\NookController;
use App\Http\Controllers\FriendsController;
use Illuminate\Support\Facades\Route;

Route::post('/favorites/toggle', [FavoritesController::class, 'toggle'])->middleware('auth');

# Books Explore Page 
Route::get('/', [BookSearchController::class, 'search'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');


#Books Details Page
Route::get('/books/{id}', [BookSearchController::class, 'show'])
    ->middleware(['auth', 'verified'])
    ->name('books.show');
Route::post('/books/{id}/comments', [CommentController::class, 'store'])->name('comments.store');
Route::patch('/books/{bookId}/comments/{commentId}', [CommentController::class, 'update'])->name('comments.update');
Route::delete('/books/{bookId}/comments/{commentId}', [CommentController::class, 'destroy'])->name('comments.delete');

#Fav Books Page
Route::get('/favorites', [FavoritesController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('favorites');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

#Friends functionality 
Route::post('/friends/send', [FriendsController::class, 'sendRequest'])->name('friends.send');
Route::post('/friends/accept/{id}', [FriendsController::class, 'acceptRequest'])->name('friends.accept');
Route::delete('/friends/remove/{id}', [FriendsController::class, 'removeFriend'])->name('friends.remove');

Route::get('/friends', [FriendsController::class, 'listFriends'])->name('friends.list');
Route::post('/search-users', [FriendsController::class, 'searchUsers'])->name('user.search');
Route::get('/search-results', [FriendsController::class, 'searchUsers'])->name('user.search.results');

# Nook page
Route::get('/nook/{userId}', [NookController::class, 'show'])->name('nook.show');




require __DIR__.'/auth.php';
