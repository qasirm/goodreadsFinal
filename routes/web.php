<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BookSearchController;
use App\Http\Controllers\FavoritesController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\FavoritesController;

// API route for toggling favorites
Route::post('/favorites/toggle/{book}', [FavoritesController::class, 'toggle'])->middleware('auth:sanctum');



Route::get('/', [BookSearchController::class, 'search'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

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



require __DIR__.'/auth.php';
