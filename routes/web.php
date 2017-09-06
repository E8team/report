<?php

Route::get('/import_dormitories', function (){

    $departmentClassRepository = app(\App\Repositories\DepartmentClassRepositoryInterface::class);
    $grade = $departmentClassRepository->grades(1)->where('title', date('Y'))->first();
    $majors = $departmentClassRepository->majors($grade);
    $classes = collect();
    foreach ($majors as $major) {
        $classes = $classes->merge($departmentClassRepository->classes($major));
    }
    return view('import_dormitory', ['classes' => $classes]);
});

Route::post('/import_dormitories', function (){
    return view('import_dormitory');
})->name('import_dormitories');

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/admin/{path?}', 'IndexController@admin')->where('path', '[\/\w\.-]*');
Route::get('/{path?}', 'IndexController@index')->where('path', '[\/\w\.-]*');

