<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\API\AdminController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\CryptoController;

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
        Route::get('/admin', [CryptoController::class, 'index']);
        Route::get('/admin/user-list', [AdminController::class, 'users']);
        Route::post('/admin/add-user', [AdminController::class, 'addUser']);
        Route::put('/admin/edit-user/{id}', [AdminController::class, 'editUser']);
        Route::put('/admin/edit-admin/{id}', [AdminController::class, 'editUser']);
        Route::put('/admin/edit-admin/{id}', [AdminController::class, 'EditAdminInfos']);
        Route::delete('/admin/delete-user/{id}', [AdminController::class, 'deleteUser']);
        Route::get('/admin/admin-infos', [AdminController::class, 'getAdminInfos']);

    });

    Route::middleware(['auth', 'client'])->group(function () {
        Route::get('/client', [CryptoController::class, 'index']);
        Route::get('/client/crypto-graph/{id}', [CryptoController::class, 'getCryptoEvolution']);
        Route::get('/client/user-wallet', [UserController::class, 'userWallet']);
        Route::get('/client/user-infos', [UserController::class, 'getUserInfos']);
        Route::put('/client/edit-user-infos/{id}', [UserController::class, 'EditUserInfos']);
        Route::get('/client/purchase-history', [UserController::class, 'getHistory']);
        Route::get('/client/user-sell-crypto/{id}', [UserController::class, 'getCryptosToSell']);
        Route::get('/client/sell-all/{id}', [UserController::class, 'sellAllByCrypto']);
        Route::post('/client/add-transaction/', [UserController::class, 'addTransaction']);
        Route::patch('/client/sell-transaction/{id}', [UserController::class, 'sellTransaction']);
    });
