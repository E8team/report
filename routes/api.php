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
$api->get('students/{partOfStudentName}/search', 'StudentsController@searchStudents');
$api->get('students/{studentName}/exist', 'StudentsController@studentNameExist');

$api->group(['prefix'=>'auth'], function ($api){
    $api->post('login', 'Auth\LoginController@login');
    $api->post('logout', 'Auth\LoginController@logout');
});

$api->group(['middleware'=>'auth'], function ($api){
    $api->get('me', 'StudentsController@me');
    $api->get('dormitories/list', 'DormitoriesController@lists');
});
