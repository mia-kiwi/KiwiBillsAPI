<?php

use App\Http\Controllers\Api\CurrencyController;
use App\Http\Controllers\Api\ItemController;
use App\Http\Controllers\Api\ModifierController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// ----- MODIFIERS ----- \\
Route::get('modifiers', ModifierController::class . '@index');

Route::post('modifiers', ModifierController::class . '@store');

Route::get('modifiers/{id}', ModifierController::class . '@show');

Route::put('modifiers/{id}', ModifierController::class . '@update');

Route::delete('modifiers/{id}', ModifierController::class . '@destroy');

// ----- CURRENCIES ----- \\
Route::get('currencies', CurrencyController::class . '@index');

Route::post('currencies', CurrencyController::class . '@store');

Route::get('currencies/{id}', CurrencyController::class . '@show');

Route::put('currencies/{id}', CurrencyController::class . '@update');

Route::delete('currencies/{id}', CurrencyController::class . '@destroy');

// ----- ITEMS ----- \\
Route::get('items', ItemController::class . '@index');

Route::post('items', ItemController::class . '@store');

Route::get('items/{id}', ItemController::class . '@show');

Route::put('items/{id}', ItemController::class . '@update');

Route::delete('items/{id}', ItemController::class . '@destroy');
