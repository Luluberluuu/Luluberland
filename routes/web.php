<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\LibraryController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;


Route::get('/', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/search', [SearchController::class, 'index'])->name('search.index');
    Route::post('/search', [SearchController::class, 'search'])->name('search.run');
});

Route::post('/library/add', [LibraryController::class, 'store'])
    ->name('library.store')
    ->middleware('auth');

Route::post('/library/update', [LibraryController::class, 'update'])
    ->name('library.update')
    ->middleware('auth');

Route::post('/library/remove', [LibraryController::class, 'remove'])
    ->name('library.remove')
    ->middleware('auth');

require __DIR__.'/auth.php';
