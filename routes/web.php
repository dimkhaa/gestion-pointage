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

Route::get('/', function () {
    return view('welcome');
});
/*
Route pour aller dans mes demandes #endregion
*/

/*
Route::get('/demande', function () {
    return view('demandes');
});
*/

Route::get('/demandes', 'DemandesController@listDemandes');

Route::post('/demandes', 'DemandesController@sendDemande');

Route::get('/demandes/approuve', 'DemandesController@listDemandeApprouve');

Route::get('/demandes/refuser', 'DemandesController@listDemandeRefuser');

Route::get('/demandes/attente', 'DemandesController@listDemandeEnAttente');




//Route pour afficher une demande
//Route::get('/voir', 'DemandesController@afficherDemande');



Route::get('/demandes/voir{id}', [
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

