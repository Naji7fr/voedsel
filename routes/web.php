<?php

use App\Http\Controllers\InventoryController;
use App\Http\Controllers\KlantAdresController;
use App\Http\Controllers\KlantContactController;
use App\Http\Controllers\KlantController;
use App\Http\Controllers\ProductLeverancierController;
use App\Http\Controllers\ProductManagementController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'home')->name('home');
Route::get('/voorraad', [InventoryController::class, 'index'])->name('inventory.index');
Route::get('/productbeheer', [ProductManagementController::class, 'create'])->name('products.create');
Route::post('/productbeheer', [ProductManagementController::class, 'store'])->name('products.store');
Route::get('/productbeheer/{product}/wijzigen', [ProductManagementController::class, 'edit'])->name('products.edit');
Route::put('/productbeheer/{product}', [ProductManagementController::class, 'update'])->name('products.update');
Route::delete('/productbeheer/{product}', [ProductManagementController::class, 'destroy'])->name('products.destroy');

Route::get('/productbeheer/{product}/leverancier', [ProductLeverancierController::class, 'index'])->name('products.leverancier.index');
Route::get('/productbeheer/{product}/leverancier/create', [ProductLeverancierController::class, 'create'])->name('products.leverancier.create');
Route::post('/productbeheer/{product}/leverancier', [ProductLeverancierController::class, 'store'])->name('products.leverancier.store');
Route::get('/productbeheer/{product}/leverancier/{leverancier}/edit', [ProductLeverancierController::class, 'edit'])->name('products.leverancier.edit');
Route::put('/productbeheer/{product}/leverancier/{leverancier}', [ProductLeverancierController::class, 'update'])->name('products.leverancier.update');
Route::delete('/productbeheer/{product}/leverancier/{leverancier}', [ProductLeverancierController::class, 'destroy'])->name('products.leverancier.destroy');

Route::get('/dashboard', function () {
	return view('dashboard');
})->middleware('auth')->name('dashboard');

Route::middleware('auth')->group(function () {
	/*
	|--------------------------------------------------------------------------
	| Klant-module: overzicht, CRUD klant, adressen per klant, contactpersonen (optioneel)
	|--------------------------------------------------------------------------
	*/
	Route::get('/klant', [KlantController::class, 'index'])->name('klant.index');
	/** Demo: zelfde view als index maar zonder rijen (geen DELETE van data). */
	Route::get('/klant/demo-leeg', function () {
		return view('klant.index', ['klanten' => collect()]);
	})->name('klant.demo.leeg');
	Route::get('/klant/create', [KlantController::class, 'create'])->name('klant.create');
	Route::post('/klant', [KlantController::class, 'store'])->name('klant.store');
	Route::get('/klant/{klant}/edit', [KlantController::class, 'edit'])->name('klant.edit');
	Route::put('/klant/{klant}', [KlantController::class, 'update'])->name('klant.update');
	Route::delete('/klant/{klant}', [KlantController::class, 'destroy'])->name('klant.destroy');

	Route::get('/klant/{klant}/adres', [KlantAdresController::class, 'index'])->name('klant.adres.index');
	Route::get('/klant/{klant}/adres/create', [KlantAdresController::class, 'create'])->name('klant.adres.create');
	Route::post('/klant/{klant}/adres', [KlantAdresController::class, 'store'])->name('klant.adres.store');
	Route::get('/klant/{klant}/adres/{adres}/edit', [KlantAdresController::class, 'edit'])->name('klant.adres.edit');
	Route::put('/klant/{klant}/adres/{adres}', [KlantAdresController::class, 'update'])->name('klant.adres.update');
	Route::delete('/klant/{klant}/adres/{adres}', [KlantAdresController::class, 'destroy'])->name('klant.adres.destroy');

	/** Contactpersonen bij een klant (vereist tabel KlantContact). */
	Route::get('/klant/{klant}/contact', [KlantContactController::class, 'index'])->name('klant.contact.index');
	Route::get('/klant/{klant}/contact/create', [KlantContactController::class, 'create'])->name('klant.contact.create');
	Route::post('/klant/{klant}/contact', [KlantContactController::class, 'store'])->name('klant.contact.store');
	Route::get('/klant/{klant}/contact/{contact}/edit', [KlantContactController::class, 'edit'])->name('klant.contact.edit');
	Route::put('/klant/{klant}/contact/{contact}', [KlantContactController::class, 'update'])->name('klant.contact.update');
	Route::delete('/klant/{klant}/contact/{contact}', [KlantContactController::class, 'destroy'])->name('klant.contact.destroy');

	Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
	Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
	Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
