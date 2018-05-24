<?php

Route::get ('allowapp.com', function()
{
    return redirect()->away('http://www.allowapp.com');
});

// Customer routes
Route::group([
    'domain' => '{location}.allowapp.com',
    'middleware' => ['auth','location']], function ($location) {

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
    Route::get('addContract/{photo}/{person}','PhotosController@addContract');
    Route::delete('deleteContract','PhotosController@deleteContract');

    Route::resource('contracts', 'ContractsController');
    Route::resource('acks', 'AcksController');
});

Route::group([
    'domain' => '{location}.allowapp.test',
    'middleware' => ['auth','location']], function ($location) {

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
    Route::get('deleteContract/{photo}/{person}',['uses' => 'PhotosController@deleteContract']);

    Route::resource('contracts', 'ContractsController');
    Route::resource('acks', 'AcksController');
});

Route::get('/validatephoto/id={id}&ack={ack}&token={token}','ValidateController@accept');
Route::get('/rejectphoto/id={id}&ack={ack}&token={token}','ValidateController@reject');



Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
