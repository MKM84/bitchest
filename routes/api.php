<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\API\AdminController;
use App\Http\Controllers\API\UserController;
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
        Route::put('/admin/edit-user/{id}', [AdminController::class, 'editUser']);
        Route::delete('/admin/delete-user/{id}', [AdminController::class, 'deleteUser']);

    });


    Route::middleware(['auth', 'client'])->group(function () {
        Route::get('/client', [UserController::class, 'index']);
        Route::get('/client/user-wallet', [UserController::class, 'userWallet']);
        Route::get('/client/user-infos', [UserController::class, 'getUserInfos']);
        Route::put('/client/edit-user-infos/{id}', [UserController::class, 'EditUserInfos']);
        Route::get('/client/crypto-graph/{id}', [UserController::class, 'getCryptoEvolution']);

    });
