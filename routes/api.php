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

$api->group(['prefix' => 'auth'], function ($api) {
    $api->post('login', 'Auth\StudentsLoginController@login');
    $api->post('logout', 'Auth\StudentsLoginController@logout');
});

$api->group(['middleware' => 'auth:web'], function ($api) {
    $api->get('me', 'StudentsController@me');
    $api->get('dormitories/available', 'DormitoriesController@availableDormitories');
    $api->post('set_report', 'StudentsController@setReport');
    $api->post('select_dorm/{dormitory}', 'StudentsController@selectDorm');
    $api->get('dormitories/{dormitory}/students', 'DormitoriesController@students');
    $api->post('cancel_dorm', 'StudentsController@cancelDorm');
});

$api->group(['prefix' => 'admin', 'namespace' => 'Admin'], function ($api) {
    $api->post('login', 'Auth\LoginController@login');
    $api->post('logout', 'Auth\LoginController@logout');
    $api->post('register', 'Auth\RegisterController@register');
    $api->get('all_departments', 'DepartmentClassController@allDepartments');
    $api->group(['middleware' => 'auth:web_admin'], function ($api) {
        $api->get('me', 'UsersController@me');
        $api->get('students/{keywords}/search', 'StudentsController@searchStudents');
        $api->post('students/{student}/select_dorm/{dormitory}', 'StudentsController@selectDorm');
        $api->post('students/{student}/set_report', 'StudentsController@setReport');
        $api->post('students/{student}/cancel_report', 'StudentsController@cancelReport');
        $api->post('students/{student}/cancel_dorm', 'StudentsController@cancelDorm');
        $api->post('students/{student}/set_arrive_dorm', 'StudentsController@setArriveDorm');
        $api->post('students/{student}/allow_report', 'StudentsController@allowReport');
        $api->post('students/{student}/cancel_allow_report', 'StudentsController@cancelAllowReport');
        $api->get('students/{student}/available_dormitories', 'DormitoriesController@availableDormitories');
        $api->get('students/{student}/available_bed_num', 'DormitoriesController@availableBedNum');
        $api->get('students/{student}', 'StudentsController@show');
        $api->get('overview/{departmentId?}', 'DepartmentClassController@overview');
        $api->get('not_arrive_dorm_students/{departmentId?}', 'StudentsController@notArriveDormStudents');
        $api->get('logs/{departmentId?}', 'LogController@lists');
    });
});

// 获取反馈类型
$api->get('feedback_types', 'FeedbackController@feedbackTypes');
// 提交反馈
$api->post('feedback', 'FeedbackController@store');
