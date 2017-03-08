<?php
$namespace = "Inferno\Foundation\Http\Controllers";

Route::group(['namespace' => $namespace, 'middleware' => 'web'], function () {
    Route::get('login', function () {
        return view('inferno-foundation::login');
    });
    Route::post('login', ['as' => 'login', 'uses' => 'GuestController@postLogin']);
    Route::get('forgot-password', ['as' => 'forgot-password', 'uses' => 'GuestController@getForgotPassword']);
    Route::post('password/send', ['as' => 'password-send', 'uses' => 'GuestController@postSendForgotPassword']);
});
