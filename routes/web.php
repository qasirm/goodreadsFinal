<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BookSearchController;
use Illuminate\Support\Facades\Route;



Route::get('/', [BookSearchController::class, 'search'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('/favorites', [BookSearchController::class, 'search'])
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
