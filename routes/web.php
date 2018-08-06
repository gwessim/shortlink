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

Auth::routes();

Route::resource('links','LinkController');

Route::get('/change-locale', 'Controller@changeLocale');
Route::get('/redirect/{shortLink}', 'Controller@redirectShortLink')->name('shorturl');


Route::get('/', function() {
    return redirect('links'); 
})->name('home');
