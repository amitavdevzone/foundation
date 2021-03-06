<?php
$namespace = "Inferno\Foundation\Http\Controllers\Api";

Route::group([
    'namespace' => $namespace,
    'middleware' => ['api', 'auth:api'],
    'prefix' => 'api/v1/'], function () {
        Route::post('sidebar-toggle', 'UserApiController@postSidebarToggle');
        Route::post('image-upload', 'UserApiController@postUploadProfilePic');
        Route::post('activity-graph', 'UserApiController@postUserActivityGraph');

        Route::group(['middleware' => 'role:admin'], function() {
        	Route::post('delete-user', 'UserApiController@postDeleteUser');
        	Route::post('delete-role', 'AdminApiController@postDeleteRole');
        	Route::post('delete-permission', 'AdminApiController@postDeletePermission');
        });
    });
