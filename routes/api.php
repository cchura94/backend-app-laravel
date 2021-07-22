<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoriaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// /api/auth/login
Route::post("/auth/login", [AuthController::class, "login"]);
Route::post("/auth/logout", [AuthController::class, "logout"]);

Route::get("/auth/perfil", [AuthController::class, "perfil"])->middleware('auth:sanctum');
Route::get("/auth/refresh", [AuthController::class, "refresh"])->middleware('auth:sanctum');


Route::apiResource("categoria", CategoriaController::class)->middleware('auth:sanctum');