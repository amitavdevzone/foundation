<?php
$namespace = "Inferno\Foundation\Http\Controllers";

Route::group(['namespace' => $namespace, 'middleware' => 'web'], function () {
	/*Login*/
    Route::get('login', function () {return view('inferno-foundation::login');});
    Route::post('login', ['as' => 'login', 'uses' => 'GuestController@postLogin']);

    /*Forgot password*/
    Route::get('forgot-password', ['as' => 'forgot-password', 'uses' => 'GuestController@getForgotPassword']);
    Route::post('password/send', ['as' => 'password-send', 'uses' => 'GuestController@postSendForgotPassword']);

    /*Authenticated routes*/
    Route::group(['middleware' => 'auth'], function() {
    	Route::get('/home', ['as' => 'home', 'uses' => 'HomeController@getHomePage']);
    	Route::post('/logout', ['as' => 'logout', 'uses' => 'HomeController@postLogout']);

        Route::get('user/profile', ['as' => 'profile', 'uses' => 'HomeController@pageUserProfile']);
        Route::post('user/profile', ['as' => 'update-profile', 'uses' => 'HomeController@postUpdateProfile']);
        Route::post('user/password-change', ['as' => 'change-password', 'uses' => 'HomeController@postHandlePasswordChange']);
    });
});
