<?php

use App\Http\Controllers\CheckoutController;
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
Route::post('{lang}/register', [App\Http\Controllers\Api\RegisterUserController::class, 'register']);
Route::post('{lang}/login', [App\Http\Controllers\Api\RegisterUserController::class, 'login']);
Route::get('{lang}/categories', [App\Http\Controllers\Api\CatoriesController::class, 'index']);
Route::get('{lang}/banks', [App\Http\Controllers\Api\BankController::class, 'index']);
Route::get('{lang}/adds', [App\Http\Controllers\Api\AddsController::class, 'index']);

Route::group(
    ['middleware' => 'auth:sanctum'],
    function () {
        Route::post('{lang}/plance', [App\Http\Controllers\Api\PlanceController::class, 'storePlance']);




        Route::group(['prefix' => 'categories'], function () {
            Route::post('/create', [App\Http\Controllers\Api\CatoriesController::class, 'create']);
            Route::get('/edit/{id}', [App\Http\Controllers\Api\CatoriesController::class, 'edit']);
            Route::post('/update/{id}', [App\Http\Controllers\Api\CatoriesController::class, 'update']);
            Route::post('/delete/{id}', [App\Http\Controllers\Api\CatoriesController::class, 'delete']);
        });

        Route::group(['prefix' => 'banks'], function () {
            Route::post('/create', [App\Http\Controllers\Api\BankController::class, 'create']);
            Route::get('/edit/{id}', [App\Http\Controllers\Api\BankController::class, 'edit']);
            Route::post('/update/{id}', [App\Http\Controllers\Api\BankController::class, 'update']);
            Route::post('/delete/{id}', [App\Http\Controllers\Api\BankController::class, 'delete']);
        });
        Route::group(['prefix' => 'adds'], function () {
            Route::post('/create', [App\Http\Controllers\Api\AddsController::class, 'create']);
            Route::get('/edit/{id}', [App\Http\Controllers\Api\AddsController::class, 'edit']);
            Route::post('/update/{id}', [App\Http\Controllers\Api\AddsController::class, 'update']);
            Route::post('/delete/{id}', [App\Http\Controllers\Api\AddsController::class, 'delete']);
        });

        Route::group(['prefix' => 'transaction'], function () {
            Route::post('/', [App\Http\Controllers\Api\IncomeController::class, 'index']);
            Route::post('/create', [App\Http\Controllers\Api\IncomeController::class, 'create']);
            Route::get('/edit/{id}', [App\Http\Controllers\Api\IncomeController::class, 'edit']);
            Route::post('/update/{id}', [App\Http\Controllers\Api\IncomeController::class, 'update']);
            Route::post('/delete/{id}', [App\Http\Controllers\Api\IncomeController::class, 'delete']);
        });
    }
);
