<?php
$namespace = "Inferno\Foundation\Http\Controllers\Api";

Route::group([
    'namespace' => $namespace,
    'middleware' => ['api', 'auth:api'],
    'prefix' => 'api/v1/'], function () {
        Route::post('sidebar-toggle', 'UserApiController@postSidebarToggle');
        Route::post('image-upload', 'UserApiController@postUploadProfilePic');
    });
