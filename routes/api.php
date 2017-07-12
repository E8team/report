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
    $api->post('login', 'Auth\StudentsLoginController@login');
    $api->post('logout', 'Auth\StudentsLoginController@logout');
});

$api->group(['middleware'=>'auth:web'], function ($api){
    $api->get('me', 'StudentsController@me');
    $api->get('dormitories/available', 'DormitoriesController@availableDormitories');
    $api->post('set_report', 'StudentsController@setReport');
    $api->post('select_dorm/{dormitory}', 'StudentsController@selectDorm');
    $api->get('dormitories/{dormitory}/students', 'DormitoriesController@students');
    $api->post('cancel_dorm', 'StudentsController@cancelDorm');
});

$api->group(['prefix'=>'admin', 'namespace'=>'admin'], function ($api){
    $api->post('login', 'LoginController@login');
    $api->post('logout', 'LoginController@logout');
    $api->group(['middleware' => 'auth:web_admin'], function ($api){
        $api->get('me', 'UsersController@me');
        $api->get('students/{keywords}/search', 'StudentsController@searchStudents');
        $api->post('students/{student}/select_dorm/{dormitory}', 'StudentsController@selectDorm');
        $api->post('students/{student}/set_report', 'StudentsController@setReport');
        $api->post('students/{student}/cancel_report', 'StudentsController@calcelReport');
        $api->post('students/{student}/cancel_dorm', 'StudentsController@cancelDorm');
        $api->post('students/{student}/set_arrive_dorm', 'StudentsController@setArriveDorm');
        $api->get('students/{student}/available_dormitories', 'DormitoriesController@availableDormitories');
        $api->get('students/{student}', 'StudentsController@show');
        $api->get('overview/{departmentId?}', 'DepartmentClassController@overview');
        $api->get('not_arrive_dorm_students/{departmentId?}', 'StudentsController@notArriveDormStudents');
    });
});
