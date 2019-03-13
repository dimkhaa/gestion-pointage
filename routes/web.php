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

Route::get('/', 'Controller@index')->name('index');
Route::get('/temps-presences','TempsPresenceControlller@showAll')->name('temps-presences');
Route::get('/temps-presences-filter','TempsPresenceControlller@filterByDate')->name('filterByDate.temps-presences');
Route::get('/temps-presences-details/{id}','TempsPresenceControlller@getDetails')->name('temps-presences.details');
Route::get('/rechercheSalarie','TempsPresenceControlller@searchByName')->name('searchByName.temps-presences');
Route::get('/temps-presences-details-filter/{id}','TempsPresenceControlller@filterByDateDP')->name('filterByDate.presences-details');

