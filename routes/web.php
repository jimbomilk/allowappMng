<?php

use Illuminate\Support\Facades\URL;
/*
Route::get('/', function(){
    return "hola";
});*/

// Customer routes
if (env('APP_ENV') == 'local'){
    $domain = '{location}.allowapp.test';
}else{
    $domain = '{location}.allowapp.eu}';
}

Route::group([
    'domain' => $domain ,
    'middleware' => ['auth','location']], function ($location) {

    Route::resource('/', 'HomeController');
    Route::resource('users', 'UsersController');
    Route::resource('profiles', 'ProfilesController');
    Route::resource('groups', 'GroupsController');
    Route::resource('persons', 'PersonsController');
    Route::resource('locations', 'LocationsController');
    Route::get('historic/persons', 'HistoricController@indexPersons');
    Route::get('historic/persons/show/{id}', 'HistoricController@showPerson');

    Route::get('historic/photos', 'HistoricController@indexPhotos');
    Route::get('historic/photos/show/{id}', 'HistoricController@showPhoto');

    Route::get('historic/rightholders', 'HistoricController@indexRightholders');
    Route::get('historic/rightholders/show/{id}', 'HistoricController@showRightholder');

    Route::post('historic/emails/byperson',['uses' => 'HistoricController@emailsPerson']);
    Route::post('historic/emails/byphoto',['uses' => 'HistoricController@emailsPhoto']);
    Route::post('historic/emails/byrightholder',['uses' => 'HistoricController@emailsRightholder']);

    Route::resource('rightholders', 'RightholdersController');
    Route::get('rightholders/consentimientos/all', ['uses'=>'RightholdersController@consentimientos']);
    Route::get('rightholders/consentimientos/{id}', ['uses'=>'RightholdersController@consentimientos']);
    Route::post('rightholders/emails',['uses' => 'RightholdersController@emails']);

    Route::get('groups/publicationsites/{id}', 'PublicationsitesController@index');
    Route::resource('publicationsites', 'PublicationsitesController');
    Route::resource('photos', 'PhotosController');
    Route::get('photos/recognition/{id}',['uses' => 'PhotosController@recognition']);
    Route::get('photos/run/{id}',['uses' => 'PhotosController@makeRecognition']);
    Route::get('photos/send/{id}',['uses' => 'PhotosController@send']);
    Route::post('photos/emails',['uses' => 'PhotosController@emails']);
    Route::get('addContract/{photo}/{person}',['uses' => 'PhotosController@addContract']);
    Route::get('deleteContract/{photo}/{person}',['uses' => 'PhotosController@deleteContract']);
    Route::get('photos/share/{id}/{share}',['uses' => 'PhotosController@share']);


});




Route::group(['middleware' => ['web']], function () {

Route::get('photo/{id}/{user}/{person}/{rightholder}/{token}','LinkController@link')->name('photo.link')/*->middleware('throttle:5,5')*/;
Route::post('photo/response','LinkController@response')->name('photo.link.response')/*->middleware('throttle:5,5')*/;

Route::get('photo/shared/{id}/token/{token}','LinkController@shared')->name('photo.link.shared');

Route::get('rightholder/shared/{id}/token/{token}','LinkController@rightholder')->name('rightholder.link.shared')/*->middleware('throttle:5,5')*/;
Route::post('rightholder/response','LinkController@rightholderResponse')->name('rightholder.link.response')/*->middleware('throttle:5,5')*/;

// your routes here
});

