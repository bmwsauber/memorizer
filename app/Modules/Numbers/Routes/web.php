<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::prefix('numbers')->group(function () {
    Route::get('/id/', 'NumbersController@show')->name('numbers.show');
    Route::get('/start', 'NumbersController@start')->name('numbers.start');
    Route::get('/end', 'NumbersController@end')->name('numbers.end');
});
