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

Route::get('/', 'HomeController@index')->name('home');
Route::get('/reports', 'ReportController@index')->name('report.index');
Route::get('/cards', 'CardsController@index')->name('cards.index');
Route::get('/cards/learn', 'LearnController@show')->name('cards.learn');
Route::prefix('work')->group(function () {
    Route::get('/id/{report}', 'WorkController@show')->name('work.show');
    Route::get('/start', 'WorkController@start')->name('work.start');
    Route::get('/end', 'WorkController@end')->name('work.end');
    Route::post('/set_level/{card}', 'WorkController@setCardLevel')->name('work.set_level');
});
Route::prefix('numbers')->group(function () {
    Route::get('/id/', 'NumbersController@show')->name('numbers.show');
    Route::get('/start', 'NumbersController@start')->name('numbers.start');
    Route::get('/end', 'NumbersController@end')->name('numbers.end');
});



