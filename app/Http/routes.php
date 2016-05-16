<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

$api = app('Dingo\Api\Routing\Router');

$api->version('v1',['namespace' => 'App\Http\Controllers\Api\V1','middleware' => ['api']], function ($api) {
    #Auth
    $api->post('auth/signin', [
        'as' => 'auth.signin',
        'uses' => 'Auth\AuthController@login',
    ]);
    $api->post('auth/thirdparty', [
        'as' => 'auth.thirdparty',
        'uses' => 'Auth\AuthController@thirdParty',
    ]);
    $api->post('auth/signup', [
        'as' => 'auth.signup',
        'uses' => 'Auth\AuthController@signup',
    ]);
    $api->post('auth/token/refresh', [
        'as' => 'auth.token.refresh',
        'uses' => 'Auth\AuthController@refreshToken',
    ]);

    $api->get('activity/{id}','ActivitiesController@show');
    $api->get('activity','ActivitiesController@index');

    $api->get('default/logo','OtherController@defaultLogo');
    $api->get('upload/token','UploadController@token');

//    $api->get('test','TestController@index');

    $api->post('send/sms','SendController@sms');
    $api->post('send/email','SendController@email');

    $api->group(['middleware' =>['custom.jwt.auth']], function ($api) {
        $api->get('default/mark','MarksController@index');
        $api->post('user/mark','UserMarksController@store');

        $api->put('user','UsersController@update');


        $api->post('activity','ActivitiesController@store');
        $api->put('activity/{id}','ActivitiesController@update');
        $api->delete('activity/{id}','ActivitiesController@destroy');
    });


    $api->get('ad','AdsController@index');
});
