<?php

use App\Http\Controllers\Api\CurrencyController;
use App\Http\Controllers\Api\ItemController;
use App\Http\Controllers\Api\ModifierController;
use App\Http\Controllers\Api\LineController;
use App\Http\Controllers\Api\InvoiceController;
use App\Http\Controllers\Api\EntityController;
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

// ----- LINES ----- \\
Route::get('lines', LineController::class . '@index');

Route::post('lines', LineController::class . '@store');

Route::get('lines/{id}', LineController::class . '@show');

Route::put('lines/{id}', LineController::class . '@update');

Route::delete('lines/{id}', LineController::class . '@destroy');

// ----- INVOICES ----- \\
Route::get('invoices', InvoiceController::class . '@index');

Route::post('invoices', InvoiceController::class . '@store');

Route::get('invoices/{id}', InvoiceController::class . '@show');

Route::put('invoices/{id}', InvoiceController::class . '@update');

Route::delete('invoices/{id}', InvoiceController::class . '@destroy');

// ----- ENTITIES ----- \\
Route::get('entities', EntityController::class . '@index');

Route::post('entities', EntityController::class . '@store');

Route::get('entities/{id}', EntityController::class . '@show');

Route::put('entities/{id}', EntityController::class . '@update');

Route::delete('entities/{id}', EntityController::class . '@destroy');
