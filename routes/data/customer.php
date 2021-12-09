<?php

use App\Http\Controllers\CustomerController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Customer Routes
|--------------------------------------------------------------------------
|
| Here is where you can register customer routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "customer" middleware group. Now create something great!
|
*/

Route::group(['prefix' => 'data'], function () {
    Route::resource('customer', CustomerController::class)
        ->except([
            'show',
        ]);
});

Route::group(['prefix' => 'temp'], function () {
    Route::get('/customer', [CustomerController::class, 'recycle'])
        ->name('customer.recycle');
    Route::group(['prefix' => 'customer'], function () {
        Route::get('/restore/{id}', [CustomerController::class, 'restore']);
        Route::delete('/delete/{id}', [CustomerController::class, 'delete']);
        Route::delete('/delete-all', [CustomerController::class, 'deleteAll'])
            ->name('customer.deleteAll');
    });
});