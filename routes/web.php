<?php

use App\Http\Controllers\KlantController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth')->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/klant', [KlantController::class, 'index'])->name('klant.index');
    Route::get('/klant/create', [KlantController::class, 'create'])->name('klant.create');
    Route::post('/klant', [KlantController::class, 'store'])->name('klant.store');
    Route::get('/klant/{klant}/edit', [KlantController::class, 'edit'])->name('klant.edit');
    Route::put('/klant/{klant}', [KlantController::class, 'update'])->name('klant.update');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
