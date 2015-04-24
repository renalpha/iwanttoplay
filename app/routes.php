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

Route::get('/', array('as' => 'home', 'uses' => 'HomeController@getHome'));
Route::get('/signup', array('as' => 'signup', 'uses' => 'UserController@getSignup'));
Route::post('/signup', 'UserController@doSignup');

Route::get('/login', array('as' => 'login', 'uses' => 'UserController@getLogin'));
Route::post('/login', 'UserController@doLogin');

Route::get('/player/list/{organisation_slug}/{nowid}', array('as' => 'list', 'uses' => 'HomeController@getList'));
Route::get('/player/yt/{ytid}/{no}', array('as' => 'player', 'uses' => 'HomeController@getYTPlayer'));

Route::get('/playlist/{organisation_slug}/{tracknumber}', array('as' => 'player', 'uses' => 'HomeController@getPlayer'));
Route::get('/user/fb/register', array('as' => 'fb-register', 'uses' => 'UserController@facebookRegister'));
Route::get('/fb-login', array('as' => 'fb-login', 'uses' => 'UserController@facebookRegister'));
Route::get('/dontshowcookie', array('as' => 'cookies', 'uses' => 'HomeController@dontShowCookie'));
Route::post('/playlist/vote/{playlistid}', 'PlayListController@doVote');
// at this point user needs to be logged in as organisation
Route::group(array('before' => "sentryAuthUser"), function () {
    Route::post('/', 'PlayListController@doCreateNew');
    Route::post('/playlist/invited/{playlist_id}', 'PlayListController@doAddMeInvite');
    Route::post('/playlist/order/{playlist_id}', 'PlayListController@doReorderList');
    Route::post('/playlist/add/{playlist_id}', 'PlayListController@doAddTrack');
    Route::get('/playlist/remove/{organisation}/{trackid}', 'PlayListController@getRemoveTrack');
    Route::get('/logoff', array('as' => 'player', 'uses' => 'UserController@getSignout'));
    Route::post('/users/show/names', 'UserController@doGetNames');
    Route::get('/user/fb/invite/{playlist_id}', array('as' => 'fb-register', 'uses' => 'UserController@facebookInvite'));
    Route::get('/user/fb/accept/{slug}/{key}', array('as' => 'fb-register', 'uses' => 'UserController@facebookInviteAccept'));
    Route::post('/playlist/invite/{playlist_id}', 'PlayListController@addUserToPlaylist');
});


