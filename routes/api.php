<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CoreController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post("/login", [AuthController::class, "login"]);
Route::post("/signup", [AuthController::class, "signup"]);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::post('/users', [UserController::class, 'store']);

    Route::get("/{model}", [CoreController::class, "index"]);
    Route::get("/{model}/{id}", [CoreController::class, "show"]);
    Route::post("/{model}", [CoreController::class, "store"]);
    Route::patch("/{model}/{id}", [CoreController::class, "update"]);
    Route::delete("/{model}/{id}", [CoreController::class, "destroy"]);
});
