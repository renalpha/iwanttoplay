<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/signup', array('as' => 'signup', 'uses' => 'UserController@getSignup'));
Route::post('/signup', 'UserController@doSignup');

Route::get('/login', array('as' => 'login', 'uses' => 'UserController@getLogin'));
Route::post('/login', 'UserController@doLogin');

Route::get('/playlist/{organisation_slug}', array('as' => 'player', 'uses' => 'HomeController@getPlayer'));

// at this point user needs to be logged in as organisation
Route::group(array('before' => "sentryAuthUser"), function () {
    Route::post('/playlist/order/{playlist_id}', 'PlayListController@doReorderList');
    Route::post('/playlist/add/{playlist_id}', 'PlayListController@doAddTrack');
    Route::get('/logoff', array('as' => 'player', 'uses' => 'UserController@getSignout'));
});


