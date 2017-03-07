<?php
$namespace = "Inferno\Foundation\Http\Controllers";
Route::group(['namespace' => $namespace, 'middleware' => 'web'], function () {
	Route::get('inferno-login', function () {
	    return view('inferno-foundation::login');
	});
	Route::post('login', ['as' => 'login', 'uses' => 'GuestController@getLogin']);
});