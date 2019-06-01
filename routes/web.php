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

Route::get('/', 'TempsPresenceControlller@showAll')->name('index');
Route::get('/temps-presences','TempsPresenceControlller@showAll')->name('temps-presences');
Route::get('/temps-presences/filter','TempsPresenceControlller@filterByDate')->name('filterByDate.temps-presences');
Route::get('/temps-presences/details/{id}','TempsPresenceControlller@getDetails')->name('temps-presences.details');
Route::get('/temps-presences/search','TempsPresenceControlller@searchByName')->name('searchByName.temps-presences');
Route::get('/temps-presences/details/filter/{id}','TempsPresenceControlller@filterByDateDP')->name('filterByDate.presences-details');
Route::post('/temps-presences/export','TempsPresenceControlller@exportUsers')->name('temps-presences.export');
Route::get('/profile', 'TempsPresenceControlller@showProfile')->name('profile');

Route::get('/demandes', 'DemandesController@listDemandes')->name('demandes');

Route::post('/demandes', 'DemandesController@sendDemande');

Route::get('/demandes/approuve', 'DemandesController@listDemandeApprouve');

Route::get('/demandes/refuser', 'DemandesController@listDemandeRefuser');

Route::get('/demandes/attente', 'DemandesController@listDemandeEnAttente');

Route::get('/demandes/voir/{id}', [
    'as'=> 'afficherDemande',
    'uses'=> 'DemandesController@afficherDemande'
]);

//Route pour approuver une demande
Route::get('/demandes/voir/{id}/accepter', [
    'as' => 'approuverDemande',
    'uses'=> 'DemandesController@approuverDemande'
]);


//Route pour refuser une demande
Route::get('/demandes/voir{id}/refuser', [
    'as' => 'refuserDemande',
    'uses'=> 'DemandesController@refuserDemande'
]);

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
