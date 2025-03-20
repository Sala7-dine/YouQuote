<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\QuoteController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\TagController;

Route::get("/test", function () {
    return response()->json(["message" => "Test Message ..."]);
});

Route::post("/register", [AuthController::class, 'register']);
Route::post("/login", [AuthController::class, 'Login']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::apiResource("quotes", QuoteController::class);
    Route::apiResource("category", CategoryController::class);
    Route::apiResource("tags", TagController::class);
    Route::post('/quotes/{quote}/like', [QuoteController::class, 'like']);
    Route::delete('/quotes/{quote}/like', [QuoteController::class, 'unlike']);
});

Route::get('/quotes/random/{count}', [QuoteController::class, 'random']);
Route::get('/quotes/GetQuoteWithLength/{length}', [QuoteController::class, 'GetQuoteWithLength']);
Route::get('/Popular', [QuoteController::class, 'GetPopularQuote']);
