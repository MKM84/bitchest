<?php

use App\Http\Controllers\API\AdminController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
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

Route::middleware(['cors', 'auth'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout']);


// Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function () {
//     Route::get('/', [AdminController::class, 'index']);

// });

    // Route::get('/', [AdminController::class, 'index']);

    Route::middleware(['auth', 'admin'])->group(function () {
        Route::get('/admin', [AdminController::class, 'index']);
        Route::get('/admin/user-list', [AdminController::class, 'users']);
        Route::post('/admin/add-user', [AdminController::class, 'addUser']);

    });
