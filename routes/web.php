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

Route::resource('/', 'HomeController');

Route::group(['domain' => 'allowapp.test'], function () {
    Route::resource('/', 'HomeController');
});

// Customer routes
Route::group([
    'domain' => '{location}.allowapp.test',
    'middleware' => ['auth','location']], function ($location) {
    // Customer home page route
    // All routes in this group will receive $account as first parameter
    // Use route–model binding to have $account be an Account instance
    Route::resource('/', 'HomeController');
    Route::resource('users', 'UsersController');
    Route::resource('profiles', 'ProfilesController');
    Route::resource('groups', 'GroupsController');
    Route::resource('persons', 'PersonsController');
    Route::resource('locations', 'LocationsController');
    Route::resource('rightholders', 'RightholdersController');
    Route::get('groups/publicationsites/{id}', 'PublicationsitesController@index');
    Route::resource('publicationsites', 'PublicationsitesController');
    Route::resource('photos', 'PhotosController');
    Route::get('photos/recognition/{id}',['uses' => 'PhotosController@recognition']);
    Route::get('photos/run/{id}',['uses' => 'PhotosController@makeRecognition']);
    Route::get('photos/contracts/{id}',['uses' => 'PhotosController@contracts']);
    Route::get('addContract/{photo}/{person}',['uses' => 'PhotosController@addContract']);
    Route::get('deleteContract/{contract}',['uses' => 'PhotosController@deleteContract']);

    Route::resource('contracts', 'ContractsController');
    Route::resource('acks', 'AcksController');
});


Route::get('/validatephoto/id={id}&ack={ack}&token={token}','ValidateController@accept');
Route::get('/rejectphoto/id={id}&ack={ack}&token={token}','ValidateController@reject');


