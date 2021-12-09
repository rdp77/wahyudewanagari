<?php

use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Category Routes
|--------------------------------------------------------------------------
|
| Here is where you can register category routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "category" middleware group. Now create something great!
|
*/

Route::group(['prefix' => 'data'], function () {
    Route::resource('category', CategoryController::class)
        ->except([
            'show',
        ]);
});

Route::group(['prefix' => 'temp'], function () {
    Route::get('/category', [CategoryController::class, 'recycle'])
        ->name('category.recycle');
    Route::group(['prefix' => 'category'], function () {
        Route::get('/restore/{id}', [CategoryController::class, 'restore']);
        Route::delete('/delete/{id}', [CategoryController::class, 'delete']);
        Route::delete('/delete-all', [CategoryController::class, 'deleteAll'])
            ->name('category.deleteAll');
    });
});