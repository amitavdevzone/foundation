<?php

$namespace = "Inferno\Foundation\Http\Controllers";

Route::group(['namespace' => $namespace, 'middleware' => 'web'], function () {
	/*Login*/
    Route::get('login', function () {
        if(Auth::user()) {
            return redirect()->route('home');
        }
        return view('inferno-foundation::login');
    });
    Route::post('login', ['as' => 'login', 'uses' => 'GuestController@postLogin']);

    /*Forgot password*/
    Route::get('forgot-password', ['as' => 'forgot-password', 'uses' => 'GuestController@getForgotPassword']);
    Route::post('password/send', ['as' => 'password-send', 'uses' => 'GuestController@postSendForgotPassword']);
    Route::get('reset-password/{token}', ['as' => 'reset-password', 'uses' => 'GuestController@getResetPassword']);

    /*Authenticated routes*/
    Route::group(['middleware' => 'auth'], function() {
        Route::get('/home', ['as' => 'home', 'uses' => 'HomeController@getHomePage']);
    	Route::get('/activities', ['as' => 'user-activities', 'uses' => 'HomeController@getUserActivities']);
    	Route::post('/logout', ['as' => 'logout', 'uses' => 'HomeController@postLogout']);

        Route::get('user/profile', ['as' => 'profile', 'uses' => 'HomeController@pageUserProfile']);
        Route::post('user/profile', ['as' => 'update-profile', 'uses' => 'HomeController@postUpdateProfile']);
        Route::post('user/password-change', ['as' => 'change-password', 'uses' => 'HomeController@postHandlePasswordChange']);

        /*Admin routes*/
        Route::group(['middleware' => 'role:admin'], function() {
            /*User management*/
            Route::get('admin/user/manage', ['as' => 'manage-users', 'uses' => 'AdminController@getManageUsers']);
            Route::get('admin/user/edit/{id}', ['as' => 'edit-user', 'uses' => 'AdminController@getEditUser']);
            Route::post('admin/user/update', ['as' => 'update-user', 'uses' => 'AdminController@postUpdateUser']);
            Route::post('admin/user/add', ['as' => 'add-user', 'uses' => 'AdminController@postAddNewUser']);

            /*Roles*/
            Route::get('admin/user/roles', ['as' => 'manage-roles', 'uses' => 'AdminController@getManageRoles']);
            Route::post('admin/user/role-save', ['as' => 'save-role', 'uses' => 'AdminController@postSaveRoles']);
            Route::get('admin/user/role/{id}', ['as' => 'edit-role', 'uses' => 'AdminController@getEditRole']);
            Route::post('admin/user/role/update', ['as' => 'update-role', 'uses' => 'AdminController@postUpdateRole']);

            /*Permissions*/
            Route::get('admin/user/permissions', ['as' => 'manage-permissions', 'uses' => 'AdminController@getManagePermission']);
            Route::post('admin/user/permission-save', ['as' => 'save-permission', 'uses' => 'AdminController@postSavePermission']);
            Route::get('admin/user/permission/{id}', ['as' => 'edit-permission', 'uses' => 'AdminController@getEditPermission']);
            Route::post('admin/user/permission/update', ['as' => 'update-permission', 'uses' => 'AdminController@postUpdatePermission']);
        });
    });
});
