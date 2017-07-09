<?php



/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
$api->get('users/{partOfStudentName}/search', 'UsersController@searchUser');
$api->get('users/{studentName}/exist', 'UsersController@studentNameExist');

$api->group(['prefix'=>'auth'], function ($api){
    $api->post('login', 'Auth\LoginController@login');
    $api->post('logout', 'Auth\LoginController@logout');
});

$api->group(['middleware'=>'auth'], function ($api){
    $api->get('me', 'UserController@me');
});
