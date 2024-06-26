<?php

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

Route::post('/auth/register', [App\Http\Controllers\Api\AuthController::class, 'createUser']);
Route::post('/auth/login', [App\Http\Controllers\Api\AuthController::class, 'loginUser']);

Route::middleware('auth:sanctum')->post('/logout', [App\Http\Controllers\Api\AuthController::class, 'logout']);

Route::middleware('auth:sanctum')->group(function () {
    //here you can add all your api routes
});

// Route::middleware('cors')->group(function () {
//     Route::get('/csrf-token', function () {
//         return response()->json(['csrfToken' => csrf_token()]);
//     });
//     Route::post('/auth/login', [AuthController::class, 'login']);
//     Route::post('/auth/register', [AuthController::class, 'register']);
// });
